<?php
// +----------------------------------------------------------------------+
// |                          Japanese Date                               |
// +----------------------------------------------------------------------+
// | PHP Version 4��5                                                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2006 The Artisan Member                           |
// +----------------------------------------------------------------------+
// | Authors: Akito<akito-artisan@five-foxes.com>                         |
// +----------------------------------------------------------------------+
//
/**
 * ���ܸ�/�������ե��饹�ᥤ��ե�����
 *
 * @package JapaneseDate
 * @version 1.5
 * @since 0.1
 * @author Akito<akito-artisan@five-foxes.com>
 */

/**
 * ���񥯥饹̾
 */
define("JD_LC_CLASS_NAME", "japaneseDate_lunarCalendar");

/**
 * ���񥯥饹�ѥ�
 */
define("JD_LC_CLASS_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."lunarCalendar.php");

/**
 * �������
 */
define("JD_NO_HOLIDAY", 0);
define("JD_NEW_YEAR_S_DAY", 1);
define("JD_COMING_OF_AGE_DAY", 2);
define("JD_NATIONAL_FOUNDATION_DAY", 3);
define("JD_THE_SHOWA_EMPEROR_DIED", 4);
define("JD_VERNAL_EQUINOX_DAY", 5);
define("JD_DAY_OF_SHOWA", 6);
define("JD_GREENERY_DAY", 7);
define("JD_THE_EMPEROR_S_BIRTHDAY", 8);
define("JD_CROWN_PRINCE_HIROHITO_WEDDING", 9);
define("JD_CONSTITUTION_DAY", 10);
define("JD_NATIONAL_HOLIDAY", 11);
define("JD_CHILDREN_S_DAY", 12);
define("JD_COMPENSATING_HOLIDAY", 13);
define("JD_CROWN_PRINCE_NARUHITO_WEDDING", 14);
define("JD_MARINE_DAY", 15);
define("JD_AUTUMNAL_EQUINOX_DAY", 16);
define("JD_RESPECT_FOR_SENIOR_CITIZENS_DAY", 17);
define("JD_SPORTS_DAY", 18);
define("JD_CULTURE_DAY", 19);
define("JD_LABOR_THANKSGIVING_DAY", 20);
define("JD_REGNAL_DAY", 21);

/**
 * ��������
 */
define("JD_VERNAL_EQUINOX_DAY_MONTH", 3);
define("JD_AUTUMNAL_EQUINOX_DAY_MONTH", 9);

/**
 * �������
 */
define("JD_SUNDAY",    0);
define("JD_MONDAY",    1);
define("JD_TUESDAY",   2);
define("JD_WEDNESDAY", 3);
define("JD_THURSDAY",  4);
define("JD_FRIDAY",    5);
define("JD_SATURDAY",  6);


/**
 * ���ܸ�/�������ե��饹
 *
 * @package JapaneseDate
 * @version 2.0
 * @since 0.1
 * @author Akito<akito-artisan@five-foxes.com>
 */
class japaneseDate
{
  /**
   * ���񥯥饹���֥�������
   * @var object
   */
  var $kyureki;
  
  /**#@+
   * @access private
   */
  var $_holiday_name = array(
    0 => "", 
    1 => "��ö",
    2 => "���ͤ���",
    3 => "����ǰ����",
    4 => "����ŷ�Ĥ����Ӥ���",
    5 => "��ʬ����",
    6 => "���¤���",
    7 => "�ߤɤ����",
    8 => "ŷ��������",
    9 => "���������οƲ��η뺧�ε�",
    10 => "��ˡ��ǰ��",
    11 => "��̱�ε���",
    12 => "���ɤ����",
    13 => "���ص���",
    14 => "���������οƲ��η뺧�ε�",
    15 => "������",
    16 => "��ʬ����",
    17 => "��Ϸ����",
    18 => "�ΰ����",
    19 => "ʸ������",
    20 => "��ϫ���դ���",
    21 => "¨�������¤ε�",
  );
  
  var $_weekday_name = array("��", "��", "��", "��", "��", "��", "��");
  
  var $_during_the_war_period_weekday_name = array("��", "��", "��", "��", "��", "��", "��");
  
  var $_month_name = array("", "�ӷ�", "ǡ��", "����", "����", "����", "��̵��", "ʸ��", "�շ�", "Ĺ��", "��̵��", "����", "����");
  
  var $_six_weekday = array("���", "�ָ�", "�辡", "ͧ��", "����", "ʩ��");
  
  var $_oriental_zodiac = array("��", "��", "��", "��", "��", "ä", "̦", "��", "̤", "��", "��", "��",);
  
  var $_era_name = array("����", "ʿ��");
  
  var $_era_calc = array(1925, 1988);
  
  var $_24_sekki = array();
  
  
  
  /**#@-*/
  
  /**
   * ���󥹥ȥ饯��
   *
   * @return void
  */
  function japaneseDate()
  {
    // �����갷�����饹
    include_once(JD_LC_CLASS_PATH);
    $lc = JD_LC_CLASS_NAME;
    $this->lc = new $lc();
    
  }
  
  /**
   * �����ν����ꥹ�Ȥ��������
   *
   * @param int $time_stamp �����ॹ�����
   * @return array
   */
  function getHolidayList($time_stamp)
  {
    switch ($this->getMonth($time_stamp)) {
      case 1:
      return $this->getJanuaryHoliday($this->getYear($time_stamp));
      case 2:
      return $this->getFebruaryHoliday($this->getYear($time_stamp));
      case 3:
      return $this->getMarchHoliday($this->getYear($time_stamp));
      case 4:
      return $this->getAprilHoliday($this->getYear($time_stamp));
      case 5:
      return $this->getMayHoliday($this->getYear($time_stamp));
      case 6:
      return $this->getJuneHoliday($this->getYear($time_stamp));
      case 7:
      return $this->getJulyHoliday($this->getYear($time_stamp));
      case 8:
      return $this->getAugustHoliday($this->getYear($time_stamp));
      case 9:
      return $this->getSeptemberHoliday($this->getYear($time_stamp));
      case 10:
      return $this->getOctoberHoliday($this->getYear($time_stamp));
      case 11:
      return $this->getNovemberHoliday($this->getYear($time_stamp));
      case 12:
      return $this->getDecemberHoliday($this->getYear($time_stamp));
    }
  }
  
  /**
   * ���٥������֤�
   *
   * @param int $time_stamp �����ॹ�����
   * @return int
   */
  function getOrientalZodiac($time_stamp)
  {
    $res = ($this->getYear($time_stamp)+9)%12;
    return $res;
  }
  
  /**
   * ǯ�業�����֤�
   *
   * @param int $time_stamp �����ॹ�����
   * @return int
   */
  function getEraName($time_stamp)
  {
    if (mktime(0, 0, 0, 1 , 7, 1989) >= $time_stamp) {
      //����
      return 0;
    } else {
      //ʿ��
      return 1;
    }
  }

  /**
   * ������֤�
   *
   * @param int $time_stamp �����ॹ�����
   * @param int ����⡼��(���ˤ���ȡ���ư����)
   * @return int
   */
  function getEraYear($time_stamp, $key = -1)
  {
    if ($key == -1) {
      $key = $this->getEraName($time_stamp);
    }
    return $this->getYear($time_stamp)-$this->_era_calc[$key];
  }
  
  /**
   * ���ܸ�ե����ޥåȤ��줿����̾���֤�
   *
   * @param int $key ��������
   * @return string
   */
  function viewHoliday($key)
  {
    return $this->_holiday_name[$key];
  }
  
  /**
   * ���ܸ�ե����ޥåȤ��줿����̾���֤�
   *
   * @param int $key ��������
   * @return string
   */
  function viewWeekday($key)
  {
    return $this->_weekday_name[$key];
  }
  
  
  /**
   * ���ܸ�ե����ޥåȤ��줿�����̾���֤�
   *
   * @param int $key ���
   * @return string
   */
  function viewMonth($key)
  {
    return $this->_month_name[$key];
  }
  
  
  /**
   * ���ܸ�ե����ޥåȤ��줿ϻ��̾���֤�
   *
   * @param int $key ϻ�˥���
   * @return string
   */
  function viewSixWeekday($key)
  {
    return array_key_exists($key, $this->_six_weekday) ? $this->_six_weekday[$key] : "";
  }
  
  
  /**
   * ���ܸ�ե����ޥåȤ��줿����������̾���֤�
   *
   * @param int $key ��������
   * @return string
   */
  function viewWarWeekday($key)
  {
    return $this->during_the_war_period_weekday_name[$key];
  }
  
  /**
   * ���ܸ�ե����ޥåȤ��줿���٤��֤�
   *
   * @param int $key ���٥���
   * @return string
   */
  function viewOrientalZodiac($key)
  {
    return $this->_oriental_zodiac[$key];
  }
  
  /**
   * ���ܸ�ե����ޥåȤ��줿ǯ����֤�
   *
   * @param int $key ǯ�業��
   * @return string
   */
  function viewEraName($key)
  {
    return $this->_era_name[$key];
  }
  
  /**
   * ��ʬ���������
   *
   * @param int $time_stamp �����ॹ�����
   * @return int �����ॹ�����
   */
  function getVrenalEquinoxDay($year)
  {
    if ($year <= 1979) {
      $day = floor(20.8357 + (0.242194 * ($year - 1980)) - floor(($year - 1980) / 4));
    } elseif ($year <= 2099) {
      $day = floor(20.8431 + (0.242194 * ($year - 1980)) - floor(($year - 1980) / 4));
    } elseif ($year <= 2150) {
      $day = floor(21.851 + (0.242194 * ($year - 1980)) - floor(($year - 1980) / 4));
    } else {
      return false;
    }
    return mktime(0, 0, 0, JD_VERNAL_EQUINOX_DAY_MONTH, $day, $year);
  }
  
  /**
   * ��ʬ���������
   *
   * @param int $time_stamp �����ॹ�����
   * @return int �����ॹ�����
   */
  function getAutumnEquinoxDay($year)
  {
    if ($year <= 1979) {
      $day = floor(23.2588 + (0.242194 * ($year - 1980)) - floor(($year - 1980) / 4));
    } elseif ($year <= 2099) {
      $day = floor(23.2488 + (0.242194 * ($year - 1980)) - floor(($year - 1980) / 4));
    } elseif ($year <= 2150) {
      $day = floor(24.2488 + (0.242194 * ($year - 1980)) - floor(($year - 1980) / 4));
    } else {
      return false;
    }
    return mktime(0, 0, 0, JD_AUTUMNAL_EQUINOX_DAY_MONTH, $day, $year);
  }
  
  /**
   * �����ॹ����פ�Ÿ�����ơ����դξܺ�������������
   *
   * @param int $time_stamp �����ॹ�����
   * @return int �����ॹ�����
   */
  function makeDateArray($time_stamp)
  {
    $res = array(
      "Year"    => $this->getYear($time_stamp), 
      "Month"   => $this->getMonth($time_stamp), 
      "Day"     => $this->getDay($time_stamp),
      "Weekday" => $this->getWeekday($time_stamp), 
    );
    
    $holiday_list = $this->getHolidayList($time_stamp);
    $res["Holiday"] = isset($holiday_list[$res["Day"]]) ? $holiday_list[$res["Day"]] : JD_NO_HOLIDAY;
    return $res;
  }
  
  /**
   * ���ˤ���Ͳ������֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   */
  function getWeekday($time_stamp)
  {
    return date("w", $time_stamp);
  }

  /**
   * ǯ����Ͳ������֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   */
  function getYear($time_stamp)
  {
    return date("Y", $time_stamp);
  }

  /**
   * �����Ͳ������֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   */
  function getMonth($time_stamp)
  {
    return date("n", $time_stamp);
  }
  
  /**
   * ������Ͳ������֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   */
  function getDay($time_stamp)
  {
    return date("j", $time_stamp);
  }
  
  /**
   * ����ɽ���ѥե����ޥåȤ��֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   */
  function getStrDay($time_stamp)
  {
    return date("d", $time_stamp);
  }
  
  /**
   * ϻ�ˤ���Ͳ������֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   */
  function getSixWeekday($time_stamp)
  {
    return (date("j", $time_stamp)+date("m", $time_stamp)) % 6;
  }
  
  /**
   * ����Ƚ����å����
   *
   * @param int $year ǯ
   * @return array
   */
  function getJanuaryHoliday($year)
  {
    $res[1] = JD_NEW_YEAR_S_DAY;
    //���ص�����ǧ
    if ($this->getWeekDay(mktime(0, 0, 0, 1, 1, $year)) == JD_SUNDAY) {
      $res[2] = JD_COMPENSATING_HOLIDAY;
    }
    if ($year >= 2000) {
      //2000ǯ�ʹߤ�������������ѹ�
      $second_monday = $this->getDayByWeekly($year, 1, JD_MONDAY, 2);
      $res[$second_monday] = JD_COMING_OF_AGE_DAY;
      
    } else {
      $res[15] = JD_COMING_OF_AGE_DAY;
      //���ص�����ǧ
      if ($this->getWeekDay(mktime(0, 0, 0, 1, 15, $year)) == JD_SUNDAY) {
        $res[16] = JD_COMPENSATING_HOLIDAY;
      }
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å����
   *
   * @param int $year ǯ
   * @return array
   */
  function getFebruaryHoliday($year)
  {
    $res[11] = JD_NATIONAL_FOUNDATION_DAY;
    //���ص�����ǧ
    if ($this->getWeekDay(mktime(0, 0, 0, 2, 11, $year)) == JD_SUNDAY) {
      $res[12] = JD_COMPENSATING_HOLIDAY;
    }
    if ($year == 1989) {
      $res[24] = JD_THE_SHOWA_EMPEROR_DIED;
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å�����
   *
   * @param int $year ǯ
   * @return array
   */
  function getMarchHoliday($year)
  {
    $VrenalEquinoxDay = $this->getVrenalEquinoxDay($year);
    $res[$this->getDay($VrenalEquinoxDay)] = JD_VERNAL_EQUINOX_DAY;
    //���ص�����ǧ
    if ($this->getWeekDay($VrenalEquinoxDay) == JD_SUNDAY) {
      $res[$this->getDay($VrenalEquinoxDay)+1] = JD_COMPENSATING_HOLIDAY;
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å��ͷ�
   *
   * @param int $year ǯ
   * @return array
   */
  function getAprilHoliday($year)
  {
    if ($year == 1959) {
      $res[10] = JD_CROWN_PRINCE_HIROHITO_WEDDING;
    }
    if ($year >= 2007) {
      $res[29] = JD_DAY_OF_SHOWA;
    } elseif ($year >= 1989) {
      $res[29] = JD_GREENERY_DAY;
    } else {
      $res[29] = JD_THE_EMPEROR_S_BIRTHDAY;
    }
    //���ص�����ǧ
    if ($this->getWeekDay(mktime(0, 0, 0, 4, 29, $year)) == JD_SUNDAY) {
      $res[30] = JD_COMPENSATING_HOLIDAY;
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å��޷�
   *
   * @param int $year ǯ
   * @return array
   */
  function getMayHoliday($year)
  {
    $res[3] = JD_CONSTITUTION_DAY;
    if ($year >= 2007) {
      $res[4] = JD_GREENERY_DAY;
    } elseif ($year >= 1986) {
      // 5/4���������ξ��Ϥ��Τޤގ��������ξ��Ϥϡط�ˡ��ǰ���ο��ص�����(2006ǯ��)
      if ($this->getWeekday(mktime(0, 0, 0, 5, 4, $year)) > JD_MONDAY) {
        $res[4] = JD_NATIONAL_HOLIDAY;
      } elseif ($this->getWeekday(mktime(0, 0, 0, 5, 4, $year)) == JD_MONDAY)  {
        $res[4] = JD_COMPENSATING_HOLIDAY;
      }
    }
    $res[5] = JD_CHILDREN_S_DAY;
    if ($this->getWeekDay(mktime(0, 0, 0, 5, 5, $year)) == JD_SUNDAY) {
      $res[6] = JD_COMPENSATING_HOLIDAY;
    }
    if ($year >= 2007) {
      // [5/3,5/4������]�ʤ顢���ص���
      if (($this->getWeekday(mktime(0, 0, 0, 5, 4, $year)) == JD_SUNDAY) || ($this->getWeekday(mktime(0, 0, 0, 5, 3, $year)) == JD_SUNDAY)) {
        $res[6] = JD_COMPENSATING_HOLIDAY;
      }
    }
    return $res;
  }

  /**
   * ����Ƚ����å�ϻ��
   *
   * @param int $year ǯ
   * @return array
   */
  function getJuneHoliday($year)
  {
    if ($year == "1993") {
      $res[9] = JD_CROWN_PRINCE_NARUHITO_WEDDING;
    } else {
      $res = array();
    }
    return $res;
  }
  
  /**
   * �Ķ�����������ޤ�
   *
   * @param int int $time_stamp ����������
   * @param int int $lim_day ��������
   * @param int boolean $luna ��������������뤫�ɤ��� (optional)
   * @param int boolean $is_bypass_holiday ������̵�뤹�뤫�ɤ��� (optional)
   * @param int boolean|array $bypass_week_arr ̵�뤹������ (optional)
   * @param int boolean|array $is_bypass_date ̵�뤹���� (optional)
   * @return array
   */
  function getWorkingDay($time_stamp, $lim_day, $luna = true, $is_bypass_holiday = true, $bypass_week_arr = false, $is_bypass_date = false )
  {
    if (is_array($bypass_week_arr)) {
      $bypass_week_arr   = array_flip($bypass_week_arr);
    } else {
      $bypass_week_arr = array();
    }
    if (is_array($is_bypass_date)) {
      $gc = array();
      foreach ($is_bypass_date as $value) {
        if (!ereg("^[1-9][0-9]*$", $value)) {
          $value = strtotime($value);
        }
        $gc[mktime(0, 0, 0, date("m", $value), date("d", $value), date("Y", $value))] = 1;
      }
      $is_bypass_date = $gc;
    } else {
      $is_bypass_date = array();
    }
    
    $res = array();
    $i = 0;
    $year  = date("Y", $time_stamp);
    $month = date("m", $time_stamp);
    $day   = date("d", $time_stamp);
    while (count($res) != $lim_day) {
      $time_stamp = mktime(0, 0, 0, $month, $day + $i, $year);
      $gc = $this->purseTime($time_stamp, $luna);
      if (
        (array_key_exists($gc["week"], $bypass_week_arr) == false) && 
        (array_key_exists($gc["time_stamp"], $is_bypass_date) == false) && 
        ($is_bypass_holiday ? $gc["holiday"] == JD_NO_HOLIDAY : true)
      ) {
        $res[] = $gc;
      }
      $i++;
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å�����
   *
   * @param int $year ǯ
   * @return array
   */
  function getJulyHoliday($year)
  {
    if ($year >= 2003) {
      $third_monday = $this->getDayByWeekly($year, 7, JD_MONDAY, 3);
      $res[$third_monday] = JD_MARINE_DAY;
    } elseif ($year >= 1996) {
      $res[20] = JD_MARINE_DAY;
      //���ص�����ǧ
      if ($this->getWeekDay(mktime(0, 0, 0, 7, 20, $year)) == JD_SUNDAY) {
        $res[21] = JD_COMPENSATING_HOLIDAY;
      }
    } else {
      $res = array();
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å�Ȭ��
   *
   * @param int $year ǯ
   * @return array
   */
  function getAugustHoliday($year)
  {
    return array();
  }

  /**
   * ����Ƚ����å����
   *
   * @param int $year ǯ
   * @return array
   */
  function getSeptemberHoliday($year)
  {
    $autumnEquinoxDay = $this->getAutumnEquinoxDay($year);
    $res[$this->getDay($autumnEquinoxDay)] = JD_AUTUMNAL_EQUINOX_DAY;
    //���ص�����ǧ
    if ($this->getWeekDay($autumnEquinoxDay) == 0) {
      $res[$this->getDay($autumnEquinoxDay)+1] = JD_COMPENSATING_HOLIDAY;
    }
    
    if ($year >= 2003) {
      $third_monday = $this->getDayByWeekly($year, 9, JD_MONDAY, 3);
      $res[$third_monday] = JD_RESPECT_FOR_SENIOR_CITIZENS_DAY;
      
      //��Ϸ�����ȡ���ʬ�����δ֤����ϵ٤ߤˤʤ�
      if (($this->getDay($autumnEquinoxDay) - 1) == ($third_monday + 1)) {
        $res[($this->getDay($autumnEquinoxDay) - 1)] = JD_NATIONAL_HOLIDAY;
      }
      
    } elseif ($year >= 1966) {
      $res[15] = JD_RESPECT_FOR_SENIOR_CITIZENS_DAY;
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å�����
   *
   * @param int $year ǯ
   * @return array
   */
  function getOctoberHoliday($year)
  {
    if ($year >= 2000) {
      //2000ǯ�ʹߤ�������������ѹ�
      $second_monday = $this->getDayByWeekly($year, 10, JD_MONDAY, 2);
      $res[$second_monday] = JD_SPORTS_DAY;
    } elseif ($year >= 1966) {
      $res[10] = JD_SPORTS_DAY;
      //���ص�����ǧ
      if ($this->getWeekDay(mktime(0, 0, 0, 10, 10, $year)) == JD_SUNDAY) {
        $res[11] = JD_COMPENSATING_HOLIDAY;
      }
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å������
   *
   * @param int $year ǯ
   * @return array
   */
  function getNovemberHoliday($year)
  {
    $res[3] = JD_CULTURE_DAY;
    //���ص�����ǧ
    if ($this->getWeekDay(mktime(0, 0, 0, 11, 3, $year)) == JD_SUNDAY) {
      $res[4] = JD_COMPENSATING_HOLIDAY;
    }
    
    if ($year == 1990) {
      $res[12] = JD_REGNAL_DAY;
    }
    
    $res[23] = JD_LABOR_THANKSGIVING_DAY;
    //���ص�����ǧ
    if ($this->getWeekDay(mktime(0, 0, 0, 11, 23, $year)) == JD_SUNDAY) {
      $res[24] = JD_COMPENSATING_HOLIDAY;
    }
    return $res;
  }
  
  /**
   * ����Ƚ����å������
   *
   * @param int $year ǯ
   * @return array
   */
  function getDecemberHoliday($year)
  {
    $res[23] = JD_THE_EMPEROR_S_BIRTHDAY;
    if ($this->getWeekDay(mktime(0, 0, 0, 12, 23, $year)) == JD_SUNDAY) {
      $res[24] = JD_COMPENSATING_HOLIDAY;
    }
    return $res;
  }
  
  /**
   * ��� �����������դ�������ޤ���
   *
   * @param int $year ǯ
   * @param int $month ��
   * @param int $weekly ����
   * @param int $renb �����ܤ�
   * @return int
   */
  function getDayByWeekly($year, $month, $weekly, $renb = 1)
  {
    switch ($weekly) {
      case 0:
        $map = array(7,1,2,3,4,5,6,);
      break;
      case 1:
        $map = array(6,7,1,2,3,4,5,);
      break;
      case 2:
        $map = array(5,6,7,1,2,3,4,);
      break;
      case 3:
        $map = array(4,5,6,7,1,2,3,);
      break;
      case 4:
        $map = array(3,4,5,6,7,1,2,);
      break;
      case 5:
        $map = array(2,3,4,5,6,7,1,);
      break;
      case 6:
        $map = array(1,2,3,4,5,6,7,);
      break;
    }
    
    $renb = 7*$renb+1;
    return $renb - $map[$this->getWeekday(mktime(0,0,0,$month,1,$year))];
  }
  
  /**
   * �����Υ������������������ޤ�
   *
   * @param int $year ǯ
   * @param int $month ��
   */
  function getCalendar($year, $month, $luna = true)
  {
    $lim = date("t", mktime(0, 0, 0, $month, 1, $year));
    return $this->getSpanCalendar($year, $month, 1, $lim, $luna);
  }
  
  /**
   * �����ϰϤΥ������������������ޤ�
   *
   * @param int $year ǯ
   * @param int $month ��
   * @param int $str ������
   * @param int $lim ����(��)
   */
  function getSpanCalendar($year, $month, $str, $lim, $luna = true)
  {
    if ($lim <= 0) {
      return array();
    }
    
    $time_stamp = mktime(0, 0, 0, $month, $str-1, $year);
    if ($luna == false) {
      while ($lim != 0) {
        $time_stamp = mktime(0, 0, 0, date("m", $time_stamp), date("d", $time_stamp) + 1, date("Y", $time_stamp));
        $gc = $this->purseTime($time_stamp);
        $res[] = $gc;
        $lim--;
      }
      return $res;
    } else {
      // ���֥ꥹ��
      $time_array = array();
      while ($lim != 0) {
        $time_stamp = mktime(0, 0, 0, date("m", $time_stamp), date("d", $time_stamp) + 1, date("Y", $time_stamp));
        $time_array[] = $time_stamp;
        $lim--;
      }
      // ����
      $luna_array = $this->getLunaCalendarList($time_array, JD_KEY_TIMESTAMP);
      foreach ($time_array as $time_stamp) {
        $gc = $this->purseTime($time_stamp, $luna_array[$time_stamp]);
        $res[] = $gc;
      }
    }
    return $res;
  }
  
  /**
   * �����ॹ����פ�Ÿ�����ơ����վ�����֤��ޤ�
   *
   * @param int $time_stamp �����ॹ�����
   * @return array
   */
  function purseTime($time_stamp, $luna = true)
  {
    $holiday = $this->getHolidayList($time_stamp);

    $day = date("j", $time_stamp);
    $res = array(
      "time_stamp" => $time_stamp, 
      "day"        => $day, 
      "strday"     => date("d", $time_stamp), 
      "holiday"    => isset($holiday[$day]) ? $holiday[$day] : JD_NO_HOLIDAY, 
      "week"       => $this->getWeekday($time_stamp),
      "month"      => date("m", $time_stamp), 
      "year"       => date("Y", $time_stamp), 
    );
    
    if ($luna === true) {
      $luna = $this->getLunarCalendar($time_stamp);
    }
    
    if (is_array($luna)) {
      $res["sixweek"]      = $this->getSixWeekday($luna["time_stamp"]);
      $res["luna_sixweek"] = $luna["time_stamp"];
      $res["is_chuki"]     = $luna["is_chuki"];
      $res["chuki"]        = $luna["chuki"];
      $res["tuitachi_jd"]  = $luna["tuitachi_jd"];
      $res["jd"]           = $luna["jd"];
      $res["luna_year"]    = $luna["year"];
      $res["luna_month"]   = $luna["month"];
      $res["luna_day"]     = $luna["day"];
      $res["uruu"]         = $luna["uruu"];
    }
    return $res;
  }
  
  /**
   * ���񡦷�����������
   *
   * @param int $time_stamp �����ॹ�����
   * @see japaneseDate_lunarCalendar::getLunarCalendar()
   * @return array
   */
  function getLunarCalendar($time_stamp)
  {
    return $this->lc->getLunarCalendar($time_stamp);
  }
  
  /**
   * ���񡦷���ꥹ�Ȥ��������
   *
   * @param array $time_stamp_array �����ॹ����פΥꥹ��
   * @param array $mode JD_KEY_TIMESTAMP|JD_KEY_ORDERD
   * @see japaneseDate_lunarCalendar::getLunaCalendarList()
   * @return array
   */
  function getLunaCalendarList($time_stamp_array, $mode = JD_KEY_ORDERD)
  {
    return $this->lc->getLunaCalendarList($time_stamp_array, $mode);
  }
  
  /**
   * ��˥å��������ॹ����פ��顢��ꥦ�����������ޤ���
   *
   * @param int $time_stamp �����ॹ�����
   * @see japaneseDate_lunarCalendar::time2JD()
   * @return float
   */
  function time2JD($time_stamp)
  {
    return $this->lc->time2JD($time_stamp);
  }
  
  
  /**
   * ��Υꥹ�Ȥ��������
   *
   * @param int $time_stamp �����ॹ�����
   * @see japaneseDate_lunarCalendar::getLunarCalendar()
   * @return array
   */
  function getTuitachiArray($time_stamp)
  {
    return $this->lc->getTuitachiArray($this->lc->getTime2JD($time_stamp));
  }
  
  
  /**
   * ���ܸ쥫�������б�����strftime()
   *
   * <pre>{@link http://php.five-foxes.com/module/php_man/index.php?web=function.strftime strftime�λ���}
   * �˲ä���
   * %J 1��31����
   * %g 1��9�ʤ���Ƭ�˥��ڡ������դ��롢1��31����
   * %K ��̾����
   * %k ϻ���ֹ�
   * %6 ϻ��
   * %K ����
   * %l �����ֹ�
   * %L ����
   * %o �����ֹ�
   * %O ����
   * %N 1��12�η�
   * %E ����ǯ
   * %G ����η�
   * %F ǯ��
   * %f ǯ��ID
   * 
   * �����ѤǤ��ޤ���</pre>
   *
   * @since 1.1
   * @param string $format �ե����ޥå�
   * @param integer $time_stamp �Ѵ������������ॹ�����(�ǥե���Ȥϸ��ߤΥ��������)
   */
  function mb_strftime($format, $time_stamp = false)
  {
    if ($time_stamp === false) {
      $time_stamp = time();
    }
    $jtime = $this->purseTime($time_stamp);
    $OrientalZodiac = $this->getOrientalZodiac($time_stamp);
    $jd_token = array(
      "%o" => $OrientalZodiac, 
      "%O" => $this->viewOrientalZodiac($OrientalZodiac), 
      "%l" => $jtime["holiday"], 
      "%L" => $this->viewHoliday($jtime["holiday"]), 
      "%K" => $this->viewWeekday($jtime["week"]), 
      "%k" => $this->viewSixWeekday($jtime["sixweek"]), 
      "%6" => $jtime["sixweek"], 
      "%g" => strlen($jtime["day"]) == 1 ? " ".$jtime["day"] : $jtime["day"], 
      "%J" => $jtime["day"], 
      "%G" => $this->viewMonth($this->getMonth($time_stamp)), 
      "%N" => $this->getMonth($time_stamp), 
      "%F" => $this->viewEraName($this->getEraName($time_stamp)),
      "%f" => $this->getEraName($time_stamp),
      "%E" => $this->getEraYear($time_stamp)
    );

    $resstr = "";
    $format_array = explode("%", $format);
    $count = count($format_array)-1;
    $i = 0;
    while (isset($format_array[$i])) {
      if (($i == 0 || $i == $count) && $format_array[$i] == "") {
        $i++;
        continue;
      } elseif ($format_array[$i] == "") {
        $resstr .= "%%";
        $i++;
        if (isset($format_array[$i])) {
          $resstr .= $format_array[$i];
        }
        $i++;
        continue;
      } else {
        $token = "%".mb_substr($format_array[$i], 0, 1);
        if (isset($jd_token[$token])) {
          $token = $jd_token[$token];
        }
        if (mb_strlen($format_array[$i]) > 1) {
          $token .= mb_substr($format_array[$i], 1);
        }
        $resstr .= $token;
        $i++;
      }
    }
    return strftime($resstr, $time_stamp);
  }
}
?>