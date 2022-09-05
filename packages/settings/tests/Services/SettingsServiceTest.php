<?php

namespace Settings\Services;

use PHPUnit\Framework\MockObject\MockObject;
use Realty\Interfaces\SettingsServiceInterface;
use Settings\Exceptions\SettingsException;
use Settings\Models\Setting;
use Settings\SettingsTestTrait;
use Tests\TestCase;
use User\Models\User;

class SettingsServiceTest extends TestCase
{
    use SettingsTestTrait;

    private SettingsService $sut;

    private MockObject $modelMock;

    private int $modelMockId = 1;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = $this->app->make(SettingsServiceInterface::class);
        $this->modelMock = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->onlyMethods(
                [
                    'getSettingByName',
                    'getAttribute',
                    'assignSetting',
                    'revokeSetting',
                ]
            )->getMock();
        $this->modelMock->method('getAttribute')->with('id')->willReturn($this->modelMockId);
    }

    public function testGetShouldReturnNull()
    {
        $this->assertNull($this->sut->get('some'));
    }

    public function testGetShouldReturnDefault()
    {
        $this->assertEquals('some value', $this->sut->get('some', 'some value'));
    }

    /**
     * @throws \Settings\Exceptions\SettingsException
     */
    public function testGet()
    {
        $property = 'some';
        $value = 'some value';
        $this->assertNull($this->sut->get($property));
        $this->sut->put($property, $value);
        $this->assertEquals($value, $this->sut->get($property));
    }

    public function testPut()
    {
        $property = 'some';
        $value = 'some value';
        $newValue = 'new value';
        $this->assertNull($this->sut->get($property));
        $this->sut->put($property, $value);
        $this->assertEquals($value, $this->sut->get($property));
        $this->sut->put($property, $newValue);
        $this->assertEquals($newValue, $this->sut->get($property));
    }

    public function testDropShouldThrowSettingsException()
    {
        $property = 'some';
        $this->assertNull($this->sut->get($property));
        $this->expectException(SettingsException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Setting where property $property not found");
        $this->sut->drop($property);
    }

    public function testDrop()
    {
        $property = 'some';
        $value = 'some value';
        $this->assertNull($this->sut->get($property));
        $this->sut->put($property, $value);
        $this->assertTrue($this->sut->has($property));
        $this->sut->drop($property);
        $this->assertFalse($this->sut->has($property));
    }

    public function testAssignSettingShouldThrowSettingNotFound()
    {
        $property = 'some';
        $this->assertNull($this->sut->get($property));
        $this->expectException(SettingsException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Setting where property $property not found");
        $this->sut->assignSetting($this->modelMock, $property);
    }

    public function testAssignSettingShouldThrowSettingAlreadyAttached()
    {
        $property = 'some';
        $value = 'some value';
        $this->sut->put($property, $value);

        $settingMock = $this->createMock(Setting::class);
        $this->modelMock->expects($this->any())->method('getSettingByName')->with($property)->willReturn($settingMock);
        $this->expectException(SettingsException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage("Setting $property already attached with ".class_basename($this->modelMock)." id: $this->modelMockId");
        $this->sut->assignSetting($this->modelMock, $property);
    }

    public function testRevokeSettingShouldThrowSettingNotFound()
    {
        $property = 'some';
        $this->assertNull($this->sut->get($property));
        $this->expectException(SettingsException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage("Setting where property $property not found");
        $this->sut->revokeSetting($this->modelMock, $property);
    }

    public function testRevokeSettingShouldThrowSettingAlreadyDetached()
    {
        $property = 'some';
        $value = 'some value';
        $this->sut->put($property, $value);

        $this->modelMock->expects($this->any())->method('getSettingByName')->with($property)->willReturn(null);
        $this->expectException(SettingsException::class);
        $this->expectExceptionCode(2);
        $this->expectExceptionMessage("Setting $property already detached with ".class_basename($this->modelMock)." id: $this->modelMockId");
        $this->sut->revokeSetting($this->modelMock, $property);
    }

    public function testAssignSetting()
    {
        $property = 'some';
        $value = 'some value';
        $this->sut->put($property, $value);

        $this->modelMock->expects($this->any())->method('getSettingByName')->with($property)->willReturn(null);

        $this->modelMock->expects($this->once())->method('assignSetting')->with(Setting::where('property', $property)->first());

        $this->sut->assignSetting($this->modelMock, $property);
    }

    public function testRevokeSetting()
    {
        $property = 'some';
        $value = 'some value';
        $this->sut->put($property, $value);

        $setting = Setting::where('property', $property)->first();
        $this->modelMock->expects($this->any())->method('getSettingByName')->with($property)->willReturn($setting);

        $this->modelMock->expects($this->once())->method('revokeSetting')->with($setting);

        $this->sut->revokeSetting($this->modelMock, $property);
    }

    public function testHas()
    {
        $property = 'some';
        $value = 'some value';
        $this->assertNull($this->sut->get($property));
        $this->sut->put($property, $value);
        $this->assertTrue($this->sut->has($property));
        $this->sut->drop($property);
        $this->assertFalse($this->sut->has($property));
    }

    public function testModelHasPropertyShouldReturnTrue()
    {
        $property = 'some';
        $settingMock = $this->createMock(Setting::class);
        $this->modelMock->expects($this->any())->method('getSettingByName')->with($property)->willReturn($settingMock);
        $this->assertTrue($this->sut->modelHasProperty($this->modelMock, $property));
    }

    public function testModelHasPropertyShouldReturnFalse()
    {
        $property = 'some';
        $this->modelMock->expects($this->any())->method('getSettingByName')->with($property)->willReturn(null);
        $this->assertFalse($this->sut->modelHasProperty($this->modelMock, $property));
    }

    public function testCreateShouldThrowSettingAlreadyExists()
    {
        $property = 'some';
        $value = 'some value';
        $this->assertNull($this->sut->get($property));
        $this->sut->create($property, $value);
        $this->assertTrue($this->sut->has($property));
        $this->expectException(SettingsException::class);
        $this->expectExceptionCode(3);
        $this->expectExceptionMessage("Setting $property already exists");
        $this->sut->create($property, $value);
    }

    public function testCreate()
    {
        $property = 'some';
        $value = 'some value';
        $this->assertNull($this->sut->get($property));
        $this->sut->create($property, $value);
        $this->assertTrue($this->sut->has($property));
    }
}
