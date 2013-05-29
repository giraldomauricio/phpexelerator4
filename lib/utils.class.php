<?
// This class renders different elements useful in forms

class utils{
	
	var $months = array("January"=>"January","February"=>"February","March"=>"March","April"=>"April","May"=>"May","June"=>"June","July"=>"July","August"=>"August","September"=>"September","October"=>"October","November"=>"November","December"=>"December");
	var $shortMonths = array("Jan"=>"Jan","Feb"=>"Feb","Mar"=>"Mar","Apr"=>"Apr","May"=>"May","Jun"=>"Jun","Jul"=>"Jul","Aug"=>"Aug","Sep"=>"Sep","Oct"=>"Oct","Nov"=>"Nov","Dec"=>"Dec");
    var $shortMonthsIndex = array(1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");
	var $days = array("Monday"=>"Monday","Tuesday"=>"Tuesday","Wednesday"=>"Wednesday","Thursday"=>"Thursday","Friday"=>"Friday","Saturday"=>"Saturday","Sunday"=>"Sunday");
	var $shortDays = array("Mon"=>"Mon","Tue"=>"Tue","Wed"=>"Wed","Thu"=>"Thu","Fri"=>"Fri","Sat"=>"Sat","Sun"=>"Sun");
	var $workingdays = array("Monday"=>"Monday","Tuesday"=>"Tuesday","Wednesday"=>"Wednesday","Thursday"=>"Thursday","Friday"=>"Friday");
	var $shortWorkingdays = array("Mon"=>"Mon","Tue"=>"Tue","Wed"=>"Wed","Thu"=>"Thu","Fri"=>"Fri");
	var $weekDaysOrdered = array("2"=>"Mon","3"=>"Tue","4"=>"Wed","5"=>"Thu","6"=>"Fri","7"=>"Sat","1"=>"Sun");
	var $boolean = array("True"=>"True","False"=>"False");
	var $yesNo = array(0 => "No", 1 => "Yes");
	var $activation = array(1=>"Active",0=>"Inactive");
	var $custom = array();
	var $daysOfMonth = array();
        var $minutes = array();
	var $hours = array();
	var $hoursMil = array();
	var $minutesIntervals = 0;
	var $monthsFullDisplay = true;
	var $yearsPast = array();
	var $yearsFuture = array();
    var $yearsPastFuture = array();
	var $maxYear = 1900;
    var $minYear = 1900;
	var $startAgeRestriction = 0;
	var $series = array();
    var $onChange = "";
	var $countries = array(
                "United States",
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe",
        "Caribbean",
        "Puerto Rico"
	);
    var $cssClass = "";
	
	function __construct()
	{
		$this->maxYear = date("Y") - 100;
		for($i=1;$i<=31;$i++) array_push($this->daysOfMonth,$i);
		for($i=date("Y")-$this->startAgeRestriction;$i>=$this->maxYear;$i--) array_push($this->yearsPast,$i);
		for($i=date("Y");$i<=date("Y")+10;$i++) array_push($this->yearsFuture,$i);
		for($i=0;$i<=23;$i++) array_push($this->hoursMil,sprintf("%02d", $i).":00");
                for($i=0;$i<=59;$i++) array_push($this->minutes,sprintf("%02d", $i).":00");
		for($i=0;$i<=23;$i++)
		{
			if($i<12) array_push($this->hours,sprintf("%02d", $i).":00 AM");
			if($i==12) array_push($this->hours,sprintf("%02d", $i).":00 PM");
			if($i>12) array_push($this->hours,sprintf("%02d", $i-12).":00 PM");
		}
	}
	
	function dropdown($id,$array,$selected)
	{
        if($this->onChange) $res = "<select name=\"".$id."\" id=\"".$id."\" onChange=\"".$this->onChange."\"".$this->cssClass.">\n";
		else $res = "<select name=\"".$id."\" id=\"".$id."\"".$this->cssClass.">\n";
		foreach($array as $key => $value)
		{
			if($selected == $key) $res .= "<option value=\"".$key."\" selected>".$value."</option>\n";
			else $res .= "<option value=\"".$key."\">".$value."</option>\n";
		}
		$res .= "</select>";
		return $res;
	}
	
    function renderYearsPastFuture($id,$selected=0)
	{
        for($i=$this->minYear;$i<=$this->maxYear;$i++)
        {
          
          array_push ($this->yearsPastFuture, $i);
        }
		print $this->dropdown($id,$this->yearsPastFuture,$selected);
	}
    
	function renderYearsPast($id,$selected=0)
	{
		print $this->dropdown($id,$this->yearsPast,$selected);
	}
	
	function renderYearsFuture($id,$selected=0)
	{
		print $this->dropdown($id,$this->yearsFuture,$selected);
	}
	
	function renderMonths($id,$selected=0)
	{
		print $this->dropdown($id,$this->shortMonths,$selected);
	}
	
	function renderMonthsShort($id,$selected=0)
	{
		print $this->dropdown($id,$this->months,$selected);
	}
	
	function renderFullWeek($id,$selected=0)
	{
		print $this->dropdown($id,$this->days,$selected);
	}
	
	function renderFullWeekShort($id,$selected=0)
	{
		print $this->dropdown($id,$this->shortDays,$selected);
	}
	
	function renderWorkingWeek($id,$selected=0)
	{
		print $this->dropdown($id,$this->workingdays,$selected);
	}
	
	function renderWorkingWeekShort($id,$selected=0)
	{
		print $this->dropdown($id,$this->shortWorkingdays,$selected);
	}
	
	function renderDays($id,$selected=0)
	{
		print $this->dropdown($id,$this->days,$selected);
	}
	
	function renderDaysShort($id,$selected=0)
	{
		print $this->dropdown($id,$this->shortDays,$selected);
	}
	
	function render12Hours($id,$selected=0)
	{
		print $this->dropdown($id,$this->hours,$selected);
	}
	
	function render24Hours($id,$selected=0)
	{
		print $this->dropdown($id,$this->hoursMil,$selected);
	}
	
	function renderDaysOfMonth($id,$selected=0)
	{
		print $this->dropdown($id,$this->daysOfMonth,$selected);
	}
	
	function renderSeries($id,$start,$end,$selected=0)
	{
		for($i=$start;$i<=$end;$i++) $this->series[$i] = $i;
		print $this->dropdown($id,$this->series,$selected);
	}
	
	function renderBoolean($id,$selected=0)
	{
		print $this->dropdown($id,$this->boolean,$selected);
	}
	
	function renderActivation($id,$selected=0)
	{
		print $this->dropdown($id,$this->activation,$selected);
	}
	
	function renderCustom($id,$selected=0)
	{
		print $this->dropdown($id,$this->custom,$selected);
	}
	
	function renderYesNo($id,$selected=0)
	{
		print $this->dropdown($id,$this->yesNo,$selected);
	}
	
	function renderCountries($id,$selected=0)
	{
		print $this->dropdown($id,$this->countries,$selected);
	}
    
    public static function activeOrInactive($val)
    {
      $result = "";
      switch ($val)
      {
        case 0: $result = "Inactive"; break;
        case 1: $result = "Active"; break;
        default: $result = "Unknown"; break;
      }
      return $result;
    }
}
?>