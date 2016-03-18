<?php

echo"<table>";
echo "<thead>
        <tr>
            <th>Date</th>
            <th>Work Description</th>
            <th>Hours</th>
            <th>Charge Code</th>
            <th>Activity Code</th>
            <th>Approved By</th>
        </tr>
      <thead>";
echo "<tbody>";
foreach ($time_sheet as $key => $value){
    echo"<tr>";
        echo"<td>".$value['date_ts']."</td>";
        echo"<td>".$value['work_desc']."</td>";
        echo"<td>".$value['hours']."</td>";
        echo"<td>".$value['charge_code']."</td>";
        echo"<td>".$value['act_code']."</td>";
        echo"<td>".$value['approved_by']."</td>";
    echo"</tr>";
}
echo "</tbody>";
echo"</table>";
?>
