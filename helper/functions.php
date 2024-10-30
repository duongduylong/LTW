<?php
function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function check_message()
{
	if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
		echo $_SESSION['error'];
		unset($_SESSION['error']);
	}
}
function toStr($date)
{
	return $date->format('H:i');
}
function toStrYear($date)
{
	return $date->format('d-m-Y');
}
function toStrRegister($date)
{
	return $date->format('d-m-Y H:i:s');
}

// function addDate($date,$time){
// 	$str = 'PT' . sprintf('%02dM', $time);
// 	return $date->add(new DateInterval($str));
// }
function addDate($date, $minutes)
{
	$str = 'PT' . sprintf('%02dM', $minutes);
	$interval = new DateInterval($str);
	return $date->add($interval);
}
function formatYear($date)
{
	return toStrYear($date);
}
function getSchedule($creditlist,$ok1){
	$modelRegister=new ModelRegister();
	$listGv=$modelRegister->getGvByClassCreditId($creditlist->getClassCreditId());
	$listTg=$modelRegister->getTgByClassCreditId($creditlist->getClassCreditId());
	$ok=$ok1.' '. $creditlist->getSubject()->getSubjectName();
	foreach ($creditlist->getListSchedule() as $key => $schedule) {
		if (!is_null($schedule)) {
			$day='';
            if($schedule->getDayStudy()==8) $day='Chủ nhật';
            else $day=' Thứ '.$schedule->getDayStudy();
			$timeStart = $schedule->getKipStudy()->getTimeStart();
			$ok.= $day . ' kíp ' . $schedule->getKipStudy()->getKipStudyId() . ', từ ' . toStr($timeStart) . ' đến ' . toStr(addDate($timeStart, $schedule->getKipStudy()->getTimeStudy())) .
				', phòng ' . $schedule->getClassRoom()->getClassRoomName() .' '.$schedule->getClassRoom()->getBuilding(). '. Thời gian học từ ' . formatYear($schedule->getWeek()->getStartTime()) . ' đến ' . formatYear($schedule->getWeekEnd()->getEndTime()) .
				'. ';
		}
	}
	if(sizeof($listGv)!=0){                   
		$ok.= 'Giảng viên: ';
		foreach($listGv as $x=>$gv){
			if(!is_null($gv)){
				$ok.= '' .$gv->getFullName().' ';
			}
			

		}
		$ok.=', ';
	
	}
	if(sizeof($listTg)!=0){
		$ok.= 'Trợ giảng: ';
		foreach($listTg as $x=>$gv){
			if(!is_null($gv)){
				$ok.=''. $gv->getFullName().' ';
			}

		}
	}
	return $ok;
}
function viewSchedule($list){
	$ok='';
	foreach ($list as $key => $schedule) {
		if (!is_null($schedule)) {
			$day='';
            if($schedule->getDayStudy()==8) $day='Chủ nhật';
            else $day='Thứ '.$schedule->getDayStudy();
			$timeStart = $schedule->getKipStudy()->getTimeStart();
			$ok.= $day. ', ' . toStr($timeStart) . ' ' . toStr(addDate($timeStart, $schedule->getKipStudy()->getTimeStudy())) .
				', ' . $schedule->getClassRoom()->getClassRoomName() .' '.$schedule->getClassRoom()->getBuilding(). ', ' . formatYear($schedule->getWeek()->getStartTime()) . ' đến ' . formatYear($schedule->getWeekEnd()->getEndTime()) .
				'.';
		}
	}
	return $ok;
}

function showRegister($list)
{
	
	$ok = 1;
	foreach ($list as $key => $li) {
		if (!is_null($key)) {
			$creditlist = $li->getClassCredit();

			$modelRegister=new ModelRegister();
			$listGv=$modelRegister->getGvByClassCreditId($creditlist ->getClassCreditId());
			$listTg=$modelRegister->getTgByClassCreditId($creditlist ->getClassCreditId());
			echo '<tr>';
			echo '<td class="text-center align-middle">' . $ok . '</td>';
			$ok += 1;
			echo '<td class="text-center align-middle">' . $creditlist->getSubject()->getSubjectCode() . '</td>';
			echo '<td class="text-center align-middle">' . $creditlist->getSubject()->getSubjectName() . '</td>';
			echo '<td class="text-center align-middle">' . $creditlist->getGroupClass() . '</td>';
			echo '<td class="text-center align-middle">' . $creditlist->getSubject()->getCredit() . '</td>';
			echo '<td class="text-center align-middle">' . $creditlist->getGroupClass() . '</td>';

			echo '<td class="text-center align-middle">' . toStrRegister($li->getRegisterTime()) . '</td>';
			echo
				'<td class="text-justify">';
			foreach ($creditlist->getListSchedule() as $key => $schedule) {
				if (!is_null($schedule)) {
					$day='';
                    if($schedule->getDayStudy()==8) $day='Chủ nhật';
                    else $day='Thứ '.$schedule->getDayStudy();
					$timeStart = $schedule->getKipStudy()->getTimeStart();
					echo $day . ' kíp ' . $schedule->getKipStudy()->getKipStudyId() . ', từ ' . toStr($timeStart) . ' đến ' . toStr(addDate($timeStart, $schedule->getKipStudy()->getTimeStudy())) .
						', phòng ' . $schedule->getClassRoom()->getClassRoomName() .' '.$schedule->getClassRoom()->getBuilding(). '. Thời gian học từ ' . formatYear($schedule->getWeek()->getStartTime()) . ' đến ' . formatYear($schedule->getWeekEnd()->getEndTime()) .
						'<br/>';
				}
			}
			if(sizeof($listGv)!=0){
                            
				echo 'Giảng viên: ';
				foreach($listGv as $x=>$gv){
					if(!is_null($gv)){
						echo $gv->getFullName().' ';
					}

				}
				echo '<br/>';
			}
			if(sizeof($listTg)!=0){
				echo 'Trợ giảng: ';
				foreach($listTg as $x=>$gv){
					if(!is_null($gv)){
						echo $gv->getFullName().' ';
					}

				}
			}
			echo '</td>';
			echo '</tr>';
		}
	}
}

function checkClassCredit($classCredit1,$classCredit2){
	
	foreach($classCredit1->getListSchedule() as $key1=>$li1){
	
		foreach($classCredit2->getListSchedule() as $key2=>$li2){
			if(!is_null($key1)&&!is_null($key2)){
				
				if($li1->getWeek()->getWeekName()==$li2->getWeek()->getWeekName()){
					if(($li1->getDayStudy()==$li2->getDayStudy())&&$li1->getKipStudy()->getTimeStart()->format('H:i') == $li2->getKipStudy()->getTimeStart()->format('H:i')){
						return true;
					}
				}
				
			}

		}
	}
	return false;
}

function checkRegister($listGv,$listTg,$listSv,$gvMax,$tgMax,$svMax,$role){
	if($role==1){
		if(sizeof($listSv)<$svMax) return true;
		return false;
	}
	else if($role==2){
		if(sizeof($listTg)<$tgMax) return true;
		return false;
	}
	if(sizeof($listGv)<$gvMax) return true;
	return false;
	
}
function getDaysDiffBetweenDates($date1, $date2) {
	
  
	$diff = date_diff($date1, $date2);
	$days = $diff->days;
	return $days;
  }
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


