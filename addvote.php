<?php
	include("header.php");
	include("function.php");
	connect();
?>
<form action="addvote.php" method="POST" id="addvote">
Nội dung: <input type="text" name="name"><br>
Ngày: <input type="text" name="date"><br>
Kết quả: <input type="text" name="result"><br>
<input type="submit" name="ok" value="Submit!"><br>
</form>
<?php
	if (isset($_POST["ok"]))
	{
		$name=protect($_POST["name"]);
		$date=protect($_POST["date"]);
		$result=protect($_POST["result"]);
		echo $name."<br>".$date."<br>".$result."<br>";
		$time="";
		$i=0;
		for (; $i<strlen($date); $i++)
		{
			if (substr($date,$i,1)==' ')
			{
				$i+=7;
				break;
			}
			$time=$time.substr($date,$i,1);
		}
		//echo $time." ".substr($date,$i,1)."<br>";
		
		$day="";
		for (; $i<strlen($date); $i++)
		{
			if (substr($date,$i,1)==' ')
			{
				$i+=8;
				break;
			}
			$day=$day.substr($date,$i,1);
		}
		$month="";
		for (; $i<strlen($date); $i++)
		{
			if (substr($date,$i,1)==' ')
			{
				$i+=6;
				break;
			}
			$month=$month.substr($date,$i,1);
		}
		$year="";
		for (; $i<strlen($date); $i++)
		{
			if (substr($date,$i,1)==' ')
				break;
			$year=$year.substr($date,$i,1);
		}

		$time=getID("time",$time);
		
		$total="";
		$i=0;
		for (; $i<strlen($result); $i++)
		{
			if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.')
			{
				if (is_numeric($total)) 
				{
					$i++;
					break;
				}
				else $total="";
			}
			$total=$total.substr($result,$i,1);
		}
		if ($total!=0)
		{
			$ptotal="";
			for (; $i<strlen($result); $i++)
			{
				if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.' or substr($result,$i,1)=='%')
				{
					if (substr($result,$i,1)=='%') 
					{
						$i++;
						break;
					}
					else 
					if (!is_numeric($ptotal))
						$ptotal="";
					else
						$ptotal=$ptotal.".";
				}
				else
				$ptotal=$ptotal.substr($result,$i,1);
			}
		}

		//echo $total." ".$ptotal;
		$sum=round($total/($ptotal/100.0));
		$blank=round($total/($ptotal/100.0))-$total;
		$total="";
		for (; $i<strlen($result); $i++)
		{
			if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.')
			{
				if (is_numeric($total)) 
				{
					$i++;
					break;
				}
				else $total="";
			}
			$total=$total.substr($result,$i,1);
		}

		if ($total!=0)
		{
			$ptotal="";
			for (; $i<strlen($result); $i++)
			{
				if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.' or substr($result,$i,1)=='%')
				{
					if (substr($result,$i,1)=='%') 
					{
						$i++;
						break;
					}
					else 
					if (!is_numeric($ptotal))
						$ptotal="";
					else
						$ptotal=$ptotal.".";
				}
				else
				$ptotal=$ptotal.substr($result,$i,1);
			}
		}

		$yes=$total;
		$total="";
		for (; $i<strlen($result); $i++)
		{
			if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.')
			{
				if (is_numeric($total)) 
				{
					$i++;
					break;
				}
				else $total="";
			}
			$total=$total.substr($result,$i,1);
		}

		if ($total!=0)
		{
			$ptotal="";
			for (; $i<strlen($result); $i++)
			{
				if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.' or substr($result,$i,1)=='%')
				{
					if (substr($result,$i,1)=='%') 
					{
						$i++;
						break;
					}
					else 
					if (!is_numeric($ptotal))
						$ptotal="";
					else
						$ptotal=$ptotal.".";
				}
				else
				$ptotal=$ptotal.substr($result,$i,1);
			}
		}
		$no=$total;
		$total="";
		for (; $i<strlen($result); $i++)
		{
			if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.')
			{
				if (is_numeric($total)) 
				{
					$i++;
					break;
				}
				else $total="";
			}
			$total=$total.substr($result,$i,1);
		}

		if ($total!=0)
		{
			$ptotal="";
			for (; $i<strlen($result); $i++)
			{
				if (substr($result,$i,1)==' ' or substr($result,$i,1)==',' or substr($result,$i,1)=='.' or substr($result,$i,1)=='%')
				{
					if (substr($result,$i,1)=='%') 
					{
						$i++;
						break;
					}
					else 
					if (!is_numeric($ptotal))
						$ptotal="";
					else
						$ptotal=$ptotal.".";
				}
				else
				$ptotal=$ptotal.substr($result,$i,1);
			}
		}

		$white=$total;

		//echo $blank." ".$white." ".$yes." ".$no;

		$sum=$blank+$white+$yes+$no;
		$sql="INSERT INTO vote (name,yes,no,white,blank,sum,`time`,`date`) VALUES ('$name',$yes,$no,$white,$blank,$sum,$time,'$year-$month-$day')";
		echo $sql;

		$res=mysql_query($sql) or die(mysql_error());

	}
?>