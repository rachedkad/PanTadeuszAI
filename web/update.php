<FORM action="update2.php" method=post>
<SELECT name="student_id" size=5>
<?php

$con=pg_connect ("host=sbazy user=s179414 dbname=s179414 password=s179414");
$s="select * from students";
$r=pg_exec($con,$s);

for ($i=0; $i<pg_numrows($r); $i++)
{
 $student=pg_fetch_array($r,$i);
 print "<OPTION value=".$student[0].">";
 for ($j=0;$j<pg_numfields($r);$j++)
   print "$student[$j]&nbsp;&nbsp;";

}

?>
</SELECT>
<br>
<input type="submit" value="send">
</FORM>
