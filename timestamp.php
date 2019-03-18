<?php 
function chat_time_ago($date)
{
	$time_ago=strtotime($date); // converting timestamp(date) to unix time stamp
	$current_time=time();
	$time_difference=$current_time - $time_ago;
	$seconds=$time_difference;
	$minutes=round($seconds/60);
	$hours=round($seconds/3600);
	$days=round($seconds/86400);
	$weeks=round($seconds/604800);
	$months=round($seconds/2629440);
	$years=round($seconds/31553280);
	
	if($seconds<=60)
	{
		return "Just Now";
	}
	else if($minutes<=60)
	{
		if($minutes==1)
		{
			return "one minute ago";
		}
		else
		{
			return "$minutes minutes ago";
		}
	}
	else if($hours<=24)
	{
		if($hours==1)
		{ 
	      return "an hour ago";
		}
		else
		{
			return "$hours hrs ago";
		}
	}
	else if($days<=7)
	{
		if($days==1)
		{
			return "yesterday";
		}
		else
		{
			return "$days days ago";
		}
	}
	else if($weeks<=4.3) // 4.3==52/12
	{
		if($weeks==1)
		{
			return "a week ago";
		}
		else
		{
			return "$weeks weeks ago";
		}
	}
	else if($months <= 12)
	{
		if($months<=1)
		{
			return "a month ago";
		}
		else
		{
			return "$months months ago";
		}
	}
	else
	{
		if($years==1)
		{
			return "one year ago";
		}
		else
		{
		 return "$years year ago";	
		}
	}
}
?>