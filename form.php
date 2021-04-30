<?php session_start();
    include 'blocks/header.php';
    include 'db.php';
?>

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/media.css">
<title>Оформление заказа</title>
<script src="js/jquery.js"></script>
    <?php 
        if(isset($_GET['id'])) {
            echo "<h2 style='text-align: center;' class='dont-have-products'>Ваш заказ N{$_GET['id']} оформлен <p style='padding-top: 10px;'>В ближайшее время с вами свяжется на менеджер</p></h2>";
        } else {

    ?>
    <section class="buy">
        <div class="wrapper">
            <div class="buy-content">
                <div class="left-nav">
                    <div class="top-bar">
                        <div class="title">
                            <h2>Оформление заказа</h2>
                        </div>
                    </div>
                    <div class="bottom-bar">
                        <div class="form-title">
                            <p>1. Контактные данные</p>
                        </div>
                        <form action="function.php" method="post">
                            <div class="phone">
                                <p>Телефон</p>
                                <input class="form-control form-zone" required type="tel" name="tel"  placeholder="Введите номер телефона">
                            </div>
                            <div class="full-name">
                                <p>Имя и фамилия</p>
                                <input class="form-control form-zone" required type="text" name="fullName" placeholder="Введите имя и фамилию">
                            </div>
                            <script>
                                function postOfficeNumber(num) {
                                    if(num != 4) {
                                        document.getElementById('otdel').style.display='block';
                                        document.getElementById('otdel1').style.display='none';
                                    } else {
                                        document.getElementById('otdel').style.display='none';
                                        document.getElementById('otdel1').style.display='block';
                                    }
                                }
                            </script>
                            <div class="delivery">
                                <p>Способы доставки</p>
                                <select name="delivery" required onchange="postOfficeNumber(this.value)" class="form-control form-zone" id="deliv">
                                    <?php 
                                        $str = "select * from deliverymethods";
                                        $res = $dbh->query($str);
                                        $row = $res->fetchAll();
                                        
                                        foreach($row as $items) :
                                            echo "<option value='{$items['id']}'>{$items['name']}</option>";
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="cities">
                                <p>Город</p>
                                <input style="margin-bottom: 20px;" class="form-control" required type="text" onchange='onInput()' placeholder="Город" name="city" id="answerInput" list="cities">
                                <datalist id="cities" name="city"></datalist>
                            </div>
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
                            <script>
                                function cities(city) {
                                    let num = document.getElementById('deliv').value;
                                    $("#postNum").remove();
                                    if(num != 1) {
                                        $.ajax('ajaxDelivery.php',
                                            {
                                                type: "GET",
                                                data: {num: num, city: city},
                                                success: function(data) {
                                                    $("#postOffice").html(data)
                                                },
                                                error: function() {
                                                    alert('There was some error performing the AJAX call!');
                                                }
                                            }
                                        );
                                    } else {
                                        $("#postNum").remove();
                                    }
                                }
                            </script>
                            <label style="width: 100%; margin-bottom: 20px;" for="warehouses" id="otdel">
                                <p>Отделение</p>
                                <select placeholder="Выберите отделение" required class="form-control" name="postNumber" id="warehouses"></select>
                            </label>
                            <label style="display: none; width: 100%; margin-bottom: 20px;" for="warehouses" id="otdel1">
                                <div class="street-and-house">
                                    <p>Улица</p>
                                    <input name="street" class="form-control" type="text">
                                    <p>Дом</p>
                                    <input name="house" class="form-control" type="text">
                                </div>
                                <p>Подъезд</p>
                                <input name="entrance" class="form-control" type="text">
                                <p>Квартира</p>
                                <input name="flat" class="form-control" type="text">
                            </label>
                            <div class="post-office-number" id="postOffice"></div>
                            <div class="payment-methods">
                                <p>Способ Оплаты</p>
                                <select name="payment" required class="form-control form-zone">
                                    <?php 
                                        $str = "select * from paymentmethods";
                                        $res = $dbh->query($str);
                                        $row = $res->fetchAll();
                                        
                                        foreach($row as $items) :
                                            echo "<option value='{$items['id']}'>{$items['name']}</option>";
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            <input class="btn" name="postButton" type="submit" value="Оформить заказ">
                        </form>
                    </div>
                </div>
                <div class="right-nav">
                    <div class="card-title">
                        <h2>Состав заказа</h2>
                    </div>
                    <div class="card">
                        <?php
                            $countTotal = 0;
                            $total =  0;

                            foreach($_SESSION as $value) :
                                $str = "select * from products where id={$value['id']}";
                                $res = $dbh->query($str);
                                $row = $res->fetch();
                                $image=explode(';', $row['image']);
                                $countTotal += $value['count'];
                                $total += $value['count']*$row['price'];
                                ?>
                                <div class="product">
                                    <div class="left-bar">
                                        <img src="img/<?php echo $image[0]; ?>" alt="">
                                    </div>
                                    <div class="right-bar">
                                        <div class="price">
                                            <p><?php echo $row['price']; ?> грн</p>
                                        </div>
                                        <div class="name">
                                            <h2><?php echo $row['name']; ?></h2>
                                        </div>
                                        <div class="count">
                                            <p>Количество: <?php echo $value['count']; ?></p>
                                        </div>
                                        <div class="size">
                                            <p>Размер: <?php echo $value['size']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php

                            endforeach;
                        ?>
                        <div class="info">
                            <div class="left-bar">
                                <p>Товары <span><?php echo $countTotal; ?> шт</span></p>
                            </div>
                            <div class="right-bar">
                                <p><?php echo $total; ?> грн</p>
                            </div>
                        </div>
                        <div class="total-cost">
                            <div class="cost">
                                <p><?php echo $total; ?> грн</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    }
    include 'blocks/footer.html';
?>