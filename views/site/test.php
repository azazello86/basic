<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .mainTbl td
    {
        text-align: center;
        padding:2px 4px;
    }
</style>
<div class="test__box">
    <h1><?= Html::encode($this->title) ?></h1>
<table class="mainTbl">
    <tr>
        <td>id</td>
        <td>corporate_id</td>
        <td>number</td>
        <td>user_id</td>
        <td>created_at<br>Дата и время создания</td>
        <td>updated_at<br>Дата и время последнего обновления</td>
        <td>coordination_at<br>Дата и время согласования</td>
        <td>saved_at<br>Дата и время сохранения</td>
        <td>tag_le_id</td>
        <td>trip_purpose_id</td>
        <td>trip_purpose_parent_id</td>
        <td>trip_purpose_desc<br>Цель командировки</td>
        <td>status<br>Статус</td>
    </tr>
    <?php foreach ($results as $value)
    {
        echo '<tr>';
        foreach ($value['tripService']['trip'] as $value1)
        {
            foreach ($value1 as $value2)
            {
                echo '<td>'.$value2.'</td>';
            }
        }
        echo '</tr>';
    } ?>
</table>



</div>
