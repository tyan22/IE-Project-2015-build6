<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity.
 */
class Customer extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */

    protected function _getFullName()
    {
        if (!empty($this->_properties['firstname']) && !empty($this->_properties['surname']))
          return $this->_properties['firstname'] . '  ' .$this->_properties['surname'];
        else
          return "";
    }

    protected function _getBirthMonth()
    {
        if ($this->_properties['dob'] != null)
            return date('F',strtotime($this->_properties['dob']));
        else return null;
    }

    protected function _getBirthMonthId()
    {
        if ($this->_properties['dob'] != null)
            return date('m',strtotime($this->_properties['dob']));
        else return null;
    }

    protected function _getBirthDayOfMonth()
    {
        if ($this->_properties['dob'] != null)
            return date('d',strtotime($this->_properties['dob']));
        else return null;
    }



    protected function _getZodiacSign() {

        $zodiac = "";

        if ($this->_properties['dob'] != null) {
            $dob = $this->_properties['dob'];
            $dob = $dob->format('Y-m-d');


            list ($discard, $month, $day) = explode("-", $dob);

            if (($month == 3 && $day > 20) || ($month == 4 && $day < 20)) {
                $zodiac = 1;
            } elseif (($month == 4 && $day > 19) || ($month == 5 && $day < 21)) {
                $zodiac = 2;
            } elseif (($month == 5 && $day > 20) || ($month == 6 && $day < 21)) {
                $zodiac = 3;
            } elseif (($month == 6 && $day > 20) || ($month == 7 && $day < 23)) {
                $zodiac = 4;
            } elseif (($month == 7 && $day > 22) || ($month == 8 && $day < 23)) {
                $zodiac = 5;
            } elseif (($month == 8 && $day > 22) || ($month == 9 && $day < 23)) {
                $zodiac = 6;
            } elseif (($month == 9 && $day > 22) || ($month == 10 && $day < 23)) {
                $zodiac = 7;
            } elseif (($month == 10 && $day > 22) || ($month == 11 && $day < 22)) {
                $zodiac = 8;
            } elseif (($month == 11 && $day > 21) || ($month == 12 && $day < 22)) {
                $zodiac = 9;
            } elseif (($month == 12 && $day > 21) || ($month == 1 && $day < 20)) {
                $zodiac = 10;
            } elseif (($month == 1 && $day > 19) || ($month == 2 && $day < 19)) {
                $zodiac = 11;
            } elseif (($month == 2 && $day > 18) || ($month == 3 && $day < 21)) {
                $zodiac = 12;

            }
        }
        else
        {
            if (!empty($this->_properties['zodiac_id']))
                $zodiac = $this->_properties['zodiac_id'];
            else
                $zodiac = "";
        }
        return $zodiac;
    }




    protected $_accessible = [
        'firstname' => true,
        'surname' => true,
        'dob' => true,
        'phone' => true,
        'email' => true,
        'address' => true,
        'suburb' => true,
        'state_id' => true,
        'postcode' => true,
        'comments' => true,
        'title_id' => true,
        'zodiac_id' => true,
        'zodiacbirthstone_id' => true,
        'monthbirthstone_id' => true,
        'accessed' => true,
        'modified' => true,
        'created' => true,
        'cust_type' => true,
        '_joinData' => true,
    ];
}
