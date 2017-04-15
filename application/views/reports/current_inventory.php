<?php
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=\"test.xls\"");
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
?>

<table>
    <thead>
        <tr style="background-color:red;color:white;font-weight:bold;text-align:center;">
            <td>Brand</td>
            <td>Item Class</td>
            <td>Item Code</td>
            <td colspan="3">Description</td>
            <td>Serial</td>
            <td>In Stocks</td>
            <td>Committed</td>
            <td>Incoming</td>
            <td>Available</td>
            <td>Actual Count</td>
        </tr>
    </thead>
</table>