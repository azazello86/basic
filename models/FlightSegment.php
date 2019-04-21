<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flight_segment".
 *
 * @property integer $id
 * @property integer $flight_id
 * @property integer $num
 * @property integer $group
 * @property string $departureTerminal
 * @property string $arrivalTerminal
 * @property string $flightNumber
 * @property string $departureDate
 * @property string $arrivalDate
 * @property integer $stopNumber
 * @property integer $flightTime
 * @property integer $eTicket
 * @property string $bookingClass
 * @property string $bookingCode
 * @property integer $baggageValue
 * @property string $baggageUnit
 * @property integer $depAirportId
 * @property integer $arrAirportId
 * @property integer $opCompanyId
 * @property integer $markCompanyId
 * @property integer $aircraftId
 * @property integer $depCityId
 * @property integer $arrCityId
 * @property string $supplierRef
 * @property integer $depTimestamp
 * @property integer $arrTimestamp
 */
class FlightSegment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        return \Yii::$app->db1;
    }

    public static function tableName()
    {
        return 'flight_segment';
    }

    /**
     * @inheritdoc
     */

    public function getTripService()
    {
        // Тут связь с таблицей TripService

        return $this
            ->hasOne(TripService::className(), ['id' => 'flight_id']); // ['чужой столбец' => 'свой столбец']
    }

    public function getAirportName()
    {
        // Тут связь с таблицей AirportName

        return $this
            ->hasOne(AirportName::className(), ['airport_id' => 'depAirportId']); // ['чужой столбец' => 'свой столбец']
    }

    public function rules()
    {
        return [
            [['flight_id', 'num', 'group'], 'required'],
            [['flight_id', 'num', 'group', 'stopNumber', 'flightTime', 'eTicket', 'baggageValue', 'depAirportId', 'arrAirportId', 'opCompanyId', 'markCompanyId', 'aircraftId', 'depCityId', 'arrCityId', 'depTimestamp', 'arrTimestamp'], 'integer'],
            [['departureTerminal', 'arrivalTerminal', 'bookingCode'], 'string', 'max' => 1],
            [['flightNumber'], 'string', 'max' => 6],
            [['departureDate', 'arrivalDate'], 'string', 'max' => 20],
            [['bookingClass', 'baggageUnit'], 'string', 'max' => 16],
            [['supplierRef'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flight_id' => 'Flight ID',
            'num' => 'Num',
            'group' => 'Group',
            'departureTerminal' => 'Departure Terminal',
            'arrivalTerminal' => 'Arrival Terminal',
            'flightNumber' => 'Flight Number',
            'departureDate' => 'Departure Date',
            'arrivalDate' => 'Arrival Date',
            'stopNumber' => 'Stop Number',
            'flightTime' => 'Flight Time',
            'eTicket' => 'E Ticket',
            'bookingClass' => 'Booking Class',
            'bookingCode' => 'Booking Code',
            'baggageValue' => 'Baggage Value',
            'baggageUnit' => 'Baggage Unit',
            'depAirportId' => 'Dep Airport ID',
            'arrAirportId' => 'Arr Airport ID',
            'opCompanyId' => 'Op Company ID',
            'markCompanyId' => 'Mark Company ID',
            'aircraftId' => 'Aircraft ID',
            'depCityId' => 'Dep City ID',
            'arrCityId' => 'Arr City ID',
            'supplierRef' => 'Supplier Ref',
            'depTimestamp' => 'Dep Timestamp',
            'arrTimestamp' => 'Arr Timestamp',
        ];
    }
}
