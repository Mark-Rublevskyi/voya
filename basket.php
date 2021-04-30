<?php
session_start();
if(isset($_SESSION['role'])) {
    unset($_SESSION['role']);
    unset($_SESSION['user']);
}
?>
    <?php 
        include 'blocks/header.php';
        include 'db.php';
        if(isset($_GET['exit'])) {
            unset($_SESSION['id']);
            session_destroy();
        }
        if(count($_SESSION)>0) {
        // $basket=explode(";", $_SESSION['id']);
        // $basket1 = array_unique($basket);
        // $count=array_count_values($basket);
    ?>
    <script src="jquery3.5.1.js"></script>
    <title>Корзина</title>
    <script>
        function saveCount(value, id) {
            var el=document.getElementById(id);
            console.log(el.value);
            $.ajax('ajax.php',
                {
                    type: "GET",
                    data: {id: id, value: value},
                    success: function(data) {
                        $("#one").html(data)
                    },
                    error: function() {
                        alert('There was some error performing the AJAX call!');
                    }
                }
            );
            location="basket.php";
            
        }
    </script>

    <section class="basket">
        <div class="wrapper">
            <div class="basket-content">
                <div class="left-nav">
                    <div class="left-nav-title">
                        <h2>Корзина</h2>
                        <span id="one"></span>
                    </div>
                    <!-- <form action="order.php" method="POST"> -->
                        <?php 
                            $countTotal = 0;
                            $total =  0;
                            if(!isset($_SESSION['role'])) {
                                foreach($_SESSION as $val) : 
                                echo "<br>";
                                $str = "select * from products where id={$val['id']}";
                                $res1 = $dbh->query($str);
                                $row1 = $res1->fetch();
                                $img = explode(";", $row1['image']);
                                $img1 = $img[0];
                                $countTotal += $val['count'];
                                $total += $val['count']*$row1['price'];
                                ?>
                                <div class="product">
                                    <div class="left-bar">
                                        <div class="left-bar-image">
                                            <img src="img/<?php echo $img1; ?>" alt="">
                                        </div>
                                        <div class="left-bar-description">
                                            <div class="cost">
                                                <p><?php echo $row1['price'] ?> грн</p>
                                            </div>
                                            <div class="type">
                                                <p><?php echo $row1['name'] ?></p>
                                            </div>
                                            <div class="size">
                                                <p>Размер: <?php echo $val['size']; ?></p>
                                            </div>
                                            <div class="delete">
                                                <form action="function.php" method="post">
                                                    <input type="hidden" name="productId" value="<?php echo "id_".$val['id']."_".$val['size']; ?>"><input type="submit" value="Удалить" name="deleteProdBasket">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mobile">
                                        <div class="center-bar">
                                            <input type="number" min="0" name="count" id="<?php echo "id_".$val['id']."_".$val['size']; ?>" onchange="saveCount(this.value, this.id)" value="<?php echo $val['count'] ?>" class="number">
                                        </div>
                                        <div class="right-bar">
                                            <div class="cost">
                                                <p><?php echo $row1['price']*$val['count']; ?> грн</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                                <?php
                                endforeach; 
                            }
                        ?>
                    <!-- </form> -->
                </div>
                <div class="right-nav">
                    <div class="right-nav-title">
                        <h2>Итого</h2>
                    </div>
                    <div class="proceed-to-checkout">
                        <div class="top-bar">
                            <div class="all-products">
                                <p>Товары <span><?php echo $countTotal; ?> шт</span></p>
                            </div>
                            <div class="cost">
                                <p id="totalCost"><span><?php echo $total; ?></span> грн</p>
                            </div>
                        </div>
                        <div class="proceed-btn">
                            <form action="form.php" method="POST">
                                <button type="submit">Перейти к оформлению заказа</button>
                            </form>
                        </div>
                        <div class="clear-basket">
                            <a href="basket.php?exit=1">Очистить корзину</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        }
        else {
            echo "<h2 class='dont-have-products'>У вас еще нет товаров</h2>";
        }
        include 'blocks/footer.html';
    ?>
