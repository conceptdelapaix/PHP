<?php
date_default_timezone_set("Asia/Karachi");
//SANI: Calculator hours
class calculateHours
{
	//SANI: Declaring some important variables
	public $startDateTime; 
	public $endDateTime;
	
	private $startDate;
	private $endDate;
	
	private $startTime;
	private $endTime;
	
	public $timeStartFrom;
	public $timeEndAt;
	
	public $skipDays 		= array();
	public $skipDaysHours 	= array();
	
	public function __construct()
	{
		$this->timeStartFrom  	= "09:00:00";
		$this->timeEndAt		= "17:30:00";
	}
		
	protected function seperateDateNTime()  //SANI: initialize & store date & time seperately 
	{	
		$this->startDate = date("Y-m-d", strtotime($this->startDateTime));
		$this->endDate   = date("Y-m-d", strtotime($this->endDateTime));
		
		$this->startTime = date("H:i:s", strtotime($this->startDateTime));
		$this->endTime   = date("H:i:s", strtotime($this->endDateTime));
	}
	
	public function getAllDates() //SANI: Get all dates of given range
	{
		$this->seperateDateNTime();
		
		$allDates 	   = array(); 
		for($iteration = strtotime($this->startDate); $iteration <= strtotime($this->endDate); $iteration = strtotime('+1 day',$iteration)) //SANI: Loop through all dates
		{
			$dayName   = date('l', $iteration);  //SANI: Get Day name from date timestamp
			
			if(isset($this->skipDays) && is_array($this->skipDays) && !empty($this->skipDays)) //SANI: Check if skip days exist
			{	
				if(in_array($dayName, $this->skipDays)) //SANI: Skip off days
				{
					continue;
				}
			}
			
			$allDates[] = date("Y-m-d", $iteration);
		}
		return $allDates;
	}
	
	public function getAllHours()
	{
		$dates 		= $this->getAllDates(); //SANI: Get all dates
		$allHours 	= array();
		
		if(isset($dates) && is_array($dates) && !empty($dates)) //SANI: check if any date exist
		{
			$startHour = ((strtotime($this->startTime) < strtotime($this->timeStartFrom))?$this->startTime:$this->timeStartFrom); //SANI: Start hour
			$endHour   = ((strtotime($this->endTime) > strtotime($this->timeEndAt))?$this->timeEndAt:$this->endTime); //SANI: End hour
			
			foreach($dates as $indexedDate) //SANI: Loop through all dates
			{	
				$startLoop = strtotime($indexedDate." ".date("H",strtotime($startHour)).":00:00"); //SANI: Start hour
				$endLoop   = strtotime($indexedDate." ".date("H",strtotime($endHour)).":00:00"); //SANI: End hour
				
				for($hourLoop = $startLoop; $hourLoop <= $endLoop;  $hourLoop = strtotime('+1 hour',$hourLoop)) //SANI: Loop through All Hours of day
				{   //SANI: get hour between hour range.
					if(date("H",$hourLoop) >= date("H",strtotime($this->timeStartFrom)) && date("H",$hourLoop) <= date("H",strtotime($this->timeEndAt)))
					{
						$dateHourDayName =  date('l', $hourLoop); //SANI: Get day name
						if (array_key_exists($dateHourDayName, $this->skipDaysHours)) //SANI: Skip special days
						{ 
							$hourRange = explode("-",$this->skipDaysHours[$dateHourDayName]);  //SANI: Get hour range to skip
							
							if(date('H',$hourLoop) >= date('H',strtotime($hourRange[0])) && date('H',$hourLoop) < date('H',strtotime($hourRange[1]))) //SANI: Skip special hours
							{ 
								continue;
							}
						}
						$allHours[] = $indexedDate." ".date("H:i:s",$hourLoop);
					}
				} //for($hourLoop = $startLoop; $hourLoop <= $endLoop;  $hourLoop = strtotime('+1 hour',$hourLoop))
			} //foreach($dates as $indexedDate)
		}
		return $allHours;
	}
	
	public function getAllMinutes()
	{
		$dates 			= $this->getAllHours(); //SANI: Get all dates
		$allMinutes 	= array();

		if(isset($dates) && is_array($dates) && !empty($dates)) //SANI: check if any date exist
		{
			foreach($dates as $indexedDate) //SANI: Loop through all dates
			{	
				
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$startLoop = 0; //SANI: Start Minute
				if(date("H",strtotime($indexedDate)) == date("H", strtotime($this->timeStartFrom)))
				{
					if(date("i", strtotime($this->startDateTime)) > date("i", strtotime($this->timeStartFrom)))
					{
						$startLoop = date("i", strtotime($this->startDateTime));
					}else{
							$startLoop = date("i", strtotime($this->timeStartFrom));
					     }
				}
				
				$endLoop   = 59; //SANI: End Minute
				
				if(date("H",strtotime($indexedDate)) > date("H", strtotime($this->timeEndAt)))
				{
					$endLoop = date("i", strtotime($this->timeEndAt));
				}elseif(date("H",strtotime($indexedDate)) == date("H", strtotime($this->timeEndAt)))
					{
						if(date("H", strtotime($this->endDateTime)) > date("H",strtotime($indexedDate)))
						{
							$endLoop = date("i", strtotime($this->timeEndAt));
						}elseif(date("i", strtotime($this->endDateTime)) < date("i", strtotime($this->timeEndAt)))
								{
									$endLoop = date("i", strtotime($this->endDateTime));
								}else{
										$endLoop = date("i", strtotime($this->timeEndAt));
									 }	 
					}elseif(date("H",strtotime($indexedDate)) == date("H", strtotime($this->endDateTime)))
						{
							$endLoop = date("i", strtotime($this->endDateTime));
						}
			
				for($minuteLoop = $startLoop; $minuteLoop <= $endLoop;  $minuteLoop++) //SANI: Loop through All Hours of day
				{   //SANI: get hour between hour range.
						$dateHourDayName =  date('l', strtotime((date("Y-m-d H", strtotime($indexedDate)).":".str_pad($minuteLoop,2,"0",STR_PAD_LEFT).":00"))); //SANI: Get day name
						if (array_key_exists($dateHourDayName, $this->skipDaysHours)) //SANI: check if day exist
						{ 
							$hourRange = explode("-",$this->skipDaysHours[$dateHourDayName]);  //SANI: Get minutes range to skip
					
							if($minuteLoop >= date('i',strtotime($hourRange[0])) && $minuteLoop < date('i',strtotime($hourRange[1]))) //SANI: Skip special minute
							{   
								if(date("H",strtotime($hourRange[0])) == date("H", strtotime($indexedDate))) //SANI: Match hours
								{
									continue;
								}
							}
						}
						$allMinutes[] = date("Y-m-d H", strtotime($indexedDate)).":".str_pad($minuteLoop,2,"0",STR_PAD_LEFT).":00";
					
				} //for($hourLoop = $startLoop; $hourLoop <= $endLoop;  $hourLoop = strtotime('+1 hour',$hourLoop))
			} //foreach($dates as $indexedDate)
		}
		return $allMinutes;
	}
	
	public function getAllSeconds()
	{
		$dates 			= $this->getAllMinutes(); //SANI: Get all dates
		$allSeconds 	= array();
		
		if(isset($dates) && is_array($dates) && !empty($dates)) //SANI: check if any date exist
		{
			foreach($dates as $indexedDate) //SANI: Loop through all dates
			{	
				$startLoop = 0;
				if((strtotime(date("H:i", strtotime($indexedDate))) == strtotime(date("H:i", strtotime($this->timeStartFrom)))))
				{
					if(date("s", strtotime($this->startDateTime)) > date("s", strtotime($this->timeStartFrom)))
					{
						$startLoop = date("s", strtotime($this->startDateTime));
					}else{
							$startLoop = date("s", strtotime($this->timeStartFrom));
					     }
				}
				
				$endLoop   = 59; //SANI: End Seconds
				
				if(date("H:i",strtotime($indexedDate)) > date("H:i", strtotime($this->timeEndAt)))
				{
					$endLoop = date("s", strtotime($this->timeEndAt));
				}elseif(date("H:i",strtotime($indexedDate)) == date("H:i", strtotime($this->timeEndAt)))
					{
						if(date("H:i", strtotime($this->endDateTime)) > date("H:i",strtotime($indexedDate)))
						{
							$endLoop = date("s", strtotime($this->timeEndAt));
						}elseif(date("s", strtotime($this->endDateTime)) < date("s", strtotime($this->timeEndAt)))
								{
									$endLoop = date("s", strtotime($this->endDateTime));
								}else{
										$endLoop = date("s", strtotime($this->timeEndAt));
									 }	 
					}elseif(date("H:i",strtotime($indexedDate)) == date("H:i", strtotime($this->endDateTime)))
						{
							$endLoop = date("s", strtotime($this->endDateTime));
						}
				
				for($secondLoop = $startLoop; $secondLoop <= $endLoop;  $secondLoop++) //SANI: Loop through All Hours of day
				{  
					
						$allSeconds[] = date("Y-m-d H:i", strtotime($indexedDate)).":".str_pad($secondLoop,2,"0",STR_PAD_LEFT); 
					
					
				}
				
				
			}
		}	
		return $allSeconds;
	}
}

//////////////////SANI: USAGE /////////////
//
//				USAGE
//
//////////////////////////////////////////
$dateObj = new calculateHours();

$dateObj->startDateTime = "2018-09-03 08:00:15";
$dateObj->endDateTime   = "2018-09-03 18:00:35";

//////////////////////////////////////////////////////////
//			DATES
//////////////////////////////////////////////////////////
$dateObj->skipDays 		= array('Saturday','Sunday');

//SANI: Get all dates of provided date range
//$myDates = $dateObj->getAllDates(); 
//echo "<pre>"; print_r($myDates);

//////////////////////////////////////////////////////////
//			HOURS
//////////////////////////////////////////////////////////
//SANI: Get all hours of Date
$dateObj->timeStartFrom  	= "09:00:05";
$dateObj->timeEndAt			= "17:30:00";

$dateObj->skipDaysHours = array('Friday' => '13:00-15:00');

//$myHours = $dateObj->getAllHours();
//echo "<pre>"; print_r($myHours);

//////////////////////////////////////////////////////////
//			MINUTES
//////////////////////////////////////////////////////////
//$myMinutes = $dateObj->getAllMinutes();
//echo "<pre>"; print_r($myMinutes);

//////////////////////////////////////////////////////////
//			SECONDS
//////////////////////////////////////////////////////////
$mySeconds = $dateObj->getAllSeconds();
echo "<pre>"; print_r($mySeconds);
?>