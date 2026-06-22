<?php

use PHPUnit\Framework\TestCase;

class OGRFeatureTest7 extends TestCase
{
    public $strPathToData;
    public $strFormat;
    public $strLayerName;
    public $strFieldInt32;
    public $strFieldInt64;
    public $iFeatureIndex;
    public $iInt32Value;
    public $iInt32MaxValue;
    public $iInt64Value;

    public static function setUpBeforeClass(): void
    {
        OGRRegisterAll();
    }

    public function setUp(): void
    {
        $this->strPathToData = test_data_path('integer64');
        $this->strFormat = 'ESRI Shapefile';
        $this->strLayerName = 'test';
        $this->strFieldInt32 = 'int32';
        $this->strFieldInt64 = 'int64';
        $this->iFeatureIndex = 0;
        $this->iInt32Value = 536870912;
        $this->iInt32MaxValue = 2147483647;
        $this->iInt64Value = 2147483648;
    }

    public function tearDown(): void
    {
        $this->strPathToData = null;
        $this->strLayerName = null;
        $this->strFormat = null;
        $this->strFieldInt32 = null;
        $this->strFieldInt64 = null;
        $this->iFeatureIndex = null;
        $this->iInt32Value = null;
        $this->iInt32MaxValue = null;
        $this->iInt64Value = null;
    }

    public function testGetFieldTypeInteger32()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt32);
        $fieldDefn = OGR_FD_GetFieldDefn($layerDefn, $fieldIndex);
        $fieldType = OGR_FLD_GetType($fieldDefn);
        self::assertSame(OFTInteger, $fieldType, 'Field type is not Integer');
    }

    public function testGetFieldTypeInteger64()
    {
        if (OGR_VERSION_NUM <= 2000000) {
            self::markTestSkipped('Integer64 is only supported in GDAL >= 2');
        }
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt64);
        $fieldDefn = OGR_FD_GetFieldDefn($layerDefn, $fieldIndex);
        $fieldType = OGR_FLD_GetType($fieldDefn);
        self::assertSame(OFTInteger64, $fieldType, 'Field type is not Integer64');
    }

    public function testGetIntegerFieldAsInteger()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt32);
        $feature = OGR_L_GetFeature($layer, $this->iFeatureIndex);
        $field = OGR_F_GetFieldAsInteger($feature, $fieldIndex);
        self::assertSame(
            $this->iInt32Value,
            $field,
            'Unexpected value from OGR_F_GetFieldAsInteger for Integer field'
        );
    }

    public function testGetInteger64FieldAsInteger()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt64);
        $feature = OGR_L_GetFeature($layer, $this->iFeatureIndex);
        $field = OGR_F_GetFieldAsInteger($feature, $fieldIndex);
        self::assertSame(
            $this->iInt32MaxValue,
            $field,
            'Unexpected value from OGR_F_GetFieldAsInteger for Integer64 field'
        );
    }

    public function testGetIntegerFieldAsInteger64()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt32);
        $feature = OGR_L_GetFeature($layer, $this->iFeatureIndex);
        $field = OGR_F_GetFieldAsInteger($feature, $fieldIndex);
        self::assertSame(
            $this->iInt32Value,
            $field,
            'Unexpected value from OGR_F_GetFieldAsInteger64 for Integer field'
        );
    }

    public function testGetInteger64FieldAsInteger64()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt64);
        $feature = OGR_L_GetFeature($layer, $this->iFeatureIndex);
        $field = OGR_F_GetFieldAsInteger64($feature, $fieldIndex);
        self::assertSame(
            $this->iInt64Value,
            $field,
            'Unexpected value from OGR_F_GetFieldAsInteger64 for Integer64 field'
        );
    }

    public function testSetInteger64FieldAsInteger64()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt64);
        $feature = OGR_L_GetFeature($layer, $this->iFeatureIndex);
        $field = OGR_F_GetFieldAsInteger64($feature, $fieldIndex);
        self::assertSame(
            $this->iInt64Value,
            $field,
            'Unexpected value from OGR_F_GetFieldAsInteger64 for Integer64 field'
        );
        $newValue = $this->iInt64Value + 1;
        OGR_F_SetFieldInteger64($feature, $fieldIndex, $newValue);
        $field = OGR_F_GetFieldAsInteger64($feature, $fieldIndex);
        self::assertSame(
            $newValue,
            $field,
            'Unexpected value after OGR_F_SetFieldInteger64'
        );
    }

    public function testIsFieldNullAndSetFieldNull()
    {
        $driver = OGRGetDriverByName($this->strFormat);
        $dataSource = OGROpen($this->strPathToData, false, $driver);
        $layer = OGR_DS_GetLayerByName($dataSource, $this->strLayerName);
        $layerDefn = OGR_L_GetLayerDefn($layer);
        $fieldIndex = OGR_FD_GetFieldIndex($layerDefn, $this->strFieldInt64);
        $feature = OGR_L_GetFeature($layer, $this->iFeatureIndex);
        $field = OGR_F_GetFieldAsInteger64($feature, $fieldIndex);
        self::assertNotSame(0, $field, 'Unexpected field value');
        $isNull = OGR_F_IsFieldNull($feature, $fieldIndex);
        self::assertFalse($isNull, 'Expected field to be not null');
        $isSetAndNotNull = OGR_F_IsFieldSetAndNotNull($feature, $fieldIndex);
        self::assertTrue($isSetAndNotNull, 'Expected field to be set and not null');
        OGR_F_SetFieldNull($feature, $fieldIndex);
        $isNull = OGR_F_IsFieldNull($feature, $fieldIndex);
        self::assertTrue($isNull, 'Expected field to be null');
        $isSetAndNotNull = OGR_F_IsFieldSetAndNotNull($feature, $fieldIndex);
        self::assertFalse($isSetAndNotNull, 'Expected field to be null');
        $field = OGR_F_GetFieldAsInteger64($feature, $fieldIndex);
        self::assertSame(0, $field, 'Unexpected Integer64 value for null field');
        OGR_F_UnsetField($feature, $fieldIndex);
        $isNull = OGR_F_IsFieldNull($feature, $fieldIndex);
        self::assertFalse($isNull, 'Unset field expected to not be null');;
        $isSetAndNotNull = OGR_F_IsFieldSetAndNotNull($feature, $fieldIndex);
        self::assertFalse($isSetAndNotNull, 'Expected field to be unset');
    }
}
