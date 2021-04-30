<?php
    include 'db.php';
    $str = "select * from postofficenumber where idCity={$_GET['city']} and idDeliveryMark={$_GET['num']}";
    $res = $dbh->query($str);
    $row = $res->fetchAll();
    if($row[0]['Number'] > 0) {
        echo "<div id='postNum'><p>Отделение почти</p><select reqiure class='form-control' name='postNumber'>"; 
            foreach($row as $item) :
                echo "<option value={$item['id']}>{$item['Number']}-{$item['Address']}</option>";
            endforeach;
        echo "</select></div>";
    } else {
        echo "<div id='postNum'><p>Отделение почти</p><select reqiure class='form-control'><option value=''>Нету отделений в вашем городе</option></select></div>";
    }
    die;
?>
<select id="warehouses"></select>
<script src="js/jquery.js"></script>
<script>
    // load cities
$("#cities").load( "ajaxnova.php" );
// get warehouses
  function onInput() {
    var a=$(`#cities option[value="${$('#answerInput').val()}"]`).data('id');
var wh = $('#cities').val();

$.ajax({
url : 'ajaxnova.php',
type : 'POST',
data : {
'warehouses' : a,
},
success : function(data) {
$('#warehouses').html(data);
},
error : function(request,error)
{
$('#warehouses').html('<option>-</option>');
}
});
}
// document.querySelector('#answerInput').addEventListener('input', function(e) {
//     var input = e.target,   
//         list = input.getAttribute('list'),
//         options = document.querySelectorAll('#' + list + ' option[value="'+input.value+'"]'),
//         hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden');

//     if (options.length > 0) {
//       hiddenInput.value = input.value;
//       input.value = options[0].innerText;
//       }

// });
</script>