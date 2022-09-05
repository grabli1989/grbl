<?php

namespace User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Realty\Interfaces\RolesInterface;
use Spatie\Permission\Models\Role;
use User\Commands\DoRegister;
use User\Events\UserRegisteredEvent;
use User\Exceptions\AuthException;
use User\Exceptions\ConfirmationCodeException;
use User\Http\Requests\AssignmentRolesRequest;
use User\Http\Requests\ConfirmationPhoneRequest;
use User\Http\Requests\LoginRequest;
use User\Http\Requests\RegisterUserRequest;
use User\Http\Requests\ResetPasswordRequest;
use User\Http\Requests\UpdatePasswordRequest;
use User\Interfaces\ConfirmationCodeGeneratorInterface;
use User\Models\User;
use User\Resources\Roles\RoleResource;
use User\Resources\User\UserResource;
use User\Services\DoRegisterService;

class AuthController extends Controller
{
    /**
     * @param  RegisterUserRequest  $request
     * @param  DoRegisterService  $service
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request, DoRegisterService $service): JsonResponse
    {
        $phone = $request->get('phone');
        $password = $request->get('password');

        $command = new DoRegister($phone, $password);

        $service->handle($command);

        $user = User::where('phone', $phone)->first();

        event(new UserRegisteredEvent($user));

        $token = $user->createToken('auth_token', $this->getOnlyConfirmationAbilities())->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
        ]);
    }

    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('phone', 'password');

        /** @var User $user */
        $user = User::where('phone', $credentials['phone'])->firstOrFail();

        if (! $user->comparePassword($credentials['password'])) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        $token = $user->createToken('auth_token', $this->getAbilities($user))->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
        ]);
    }

    /**
     * @param  UserResource  $userResource
     * @return JsonResponse
     */
    public function user(UserResource $userResource): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user()->load(['info']);
        $data = $userResource->array($user);

        return response()->json(['status' => 'success', 'user' => $data]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'accessToken' => $user->createToken('auth_token', $this->getAbilities($user))->plainTextToken,
            'tokenType' => 'Bearer',
        ]);
    }

    /**
     * @param  ResetPasswordRequest  $request
     * @param  ConfirmationCodeGeneratorInterface  $codeGenerator
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request, ConfirmationCodeGeneratorInterface $codeGenerator): JsonResponse
    {
        $phone = $request->get('phone');

        /** @var User $user */
        $user = User::where('phone', $phone)->firstOrFail();

        $user->resetPassword($codeGenerator->make());
        $token = $user->createToken('auth_token', $this->getOnlyConfirmationAbilities())->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
        ]);
    }

    /**
     * @param  ConfirmationPhoneRequest  $request
     * @return JsonResponse
     */
    public function confirmation(ConfirmationPhoneRequest $request): JsonResponse
    {
        $code = $request->get('confirmationCode');
        /** @var User $user */
        $user = $request->user();

        try {
            $user->confirm($code, $user->tokenCan('assertIsConfirmed'));
        } catch (ConfirmationCodeException $e) {
            return response()->json(['status' => 'error', 'code' => ConfirmationCodeException::CODES[$e->getCode()], 'message' => $e->getMessage()]);
        }

        $temp = [
            'accessToken' => $user->createToken('auth_token', array_merge($this->getAbilities($user), ['force-set-password']))->plainTextToken,
            'tokenType' => 'Bearer',
        ];

        return response()->json(array_merge(['status' => 'success', 'message' => 'User phone confirmation successfully'], $temp));
    }

    /**
     * @param  UpdatePasswordRequest  $request
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $oldPassword = $request->get('oldPassword');
        $newPassword = $request->get('newPassword');

        try {
            if (! $user->comparePassword($oldPassword) && ! $user->tokenCan('force-set-password')) {
                throw AuthException::PasswordsDoNotIdenticalException();
            }

            $user->updatePassword($newPassword);
        } catch (AuthException $e) {
            return response()->json(['status' => 'error', 'code' => AuthException::CODES[$e->getCode()], 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'message' => 'Password updated']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => 'success', 'message' => 'Token deleted']);
    }

    /**
     * @param  RoleResource  $roleResource
     * @return JsonResponse
     */
    public function userRoles(RoleResource $roleResource): JsonResponse
    {
        $roles = [];
        foreach (Role::query()->whereIn('name', RolesInterface::USER_ROLES)->get() as $userRole) {
            $roles[$userRole->id] = $roleResource->array($userRole);
        }

        return response()->json(['status' => 'success', 'roles' => $roles]);
    }

    /**
     * @param  AssignmentRolesRequest  $request
     * @return JsonResponse
     */
    public function assignmentRoles(AssignmentRolesRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->assignRole($request->getCommand()->roles);

        return response()->json(['status' => 'success', 'message' => 'Roles successfully assignment']);
    }

    /**
     * @param  User  $user
     * @return array
     */
    private function getAbilities(User $user): array
    {
        $abilities = [];

        if (! $user->isConfirmed()) {
            return $this->getOnlyConfirmationAbilities();
        }

        $abilities[] = 'assertIsConfirmed';

        return $abilities;
    }

    /**
     * @return string[]
     */
    private function getOnlyConfirmationAbilities(): array
    {
        return ['onlyConfirmation'];
    }
}
