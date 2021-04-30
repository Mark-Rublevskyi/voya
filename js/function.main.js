function delImg(image,idProduct,id) {
    let idBlock = "i"+id.slice(1);
    let element = document.getElementById(idBlock);
    console.log(element);
    element.remove();
    // $.ajax('ajax1.php',{type: "POST",data: {image:image,idProduct:idProduct,id:idBlock},
    // success:function(data){
    //     $("#cust").html(data);
    // }});
} 

function addImg() {
    let countRow = document.getElementById('timg').rows.length;
    countRow = countRow - 1;
    let tbody = document.getElementById('timg').getElementsByTagName('TBODY')[0];
    let tr = document.createElement('tr');
    tr.id = 'i'+countRow;
    let td = document.createElement('td');
    let image = document.createElement('img');
    image.setAttribute('src','bb');
    let input1 = document.createElement('input');
    input1.type = 'file';
    input1.name = 'image[]';
    let inputButton = document.createElement('input');
    inputButton.value = 'Удалить фото';
    inputButton.setAttribute('class', 'btn btn-target');
    inputButton.type = 'button';
    inputButton.id = 'b'+countRow;
    inputButton.setAttribute('onclick','delImg(this.name, 3, this.id)');
    inputButton.name = 'add';
    td.appendChild(image);
    td.appendChild(input1);
    td.appendChild(inputButton);
    tr.appendChild(td);
    tbody.appendChild(tr);
}
