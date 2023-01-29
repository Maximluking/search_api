<?php

use hail812\adminlte\widgets\Menu;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/admin/images/admin.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php

                $items[] = ['label' => 'Tariffs', 'iconStyle' => 'fas', 'icon' => 'map-marked-alt', 'url' => ['/address'], 'active' => in_array(Yii::$app->controller->id, ['address'])];
                echo Menu::widget([
                    'items' => $items,
                ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
