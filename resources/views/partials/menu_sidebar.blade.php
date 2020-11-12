<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->    
    <a href="/" class="brand-link">
        <img    src="img/accountant3.jpg"
                alt="Accountant Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">       

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Документы
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="income-documents" class="nav-link">                                
                                <i class="fas fa-file-invoice nav-icon"></i>
                                <p>Товарные накладные</p>
                            </a>
                        </li>                       
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cubes nav-icon"></i>
                        <p>
                            Касса
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="cash-documents" class="nav-link">                                
                                <i class="fas fa-coins"></i>
                                <p>Кассовые документы</p>
                            </a>
                        </li>                       
                        <li class="nav-item">
                            <a href="payments" class="nav-link">                                
                                <i class="fas fa-coins"></i>
                                <p>Расчет с поставщиками</p>
                            </a>
                        </li>                       
                        <li class="nav-item">
                            <a href="sales-revenues" class="nav-link">                                
                                <i class="fas fa-coins"></i>
                                <p>Торговая выручка</p>
                            </a>
                        </li>                       
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                            Справочники
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="branches" class="nav-link">
                                <i class="far fa-building nav-icon"></i>
                                <p>Подразделения</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="departments" class="nav-link">
                                <i class="fas fa-cubes nav-icon"></i>
                                <p>Отделы</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="positions" class="nav-link">
                                <i class="fas fa-hard-hat nav-icon"></i>
                                <p>Должности</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="employees" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Сотрудники</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="suppliers" class="nav-link">                                
                                <i class="fas fa-truck nav-icon"></i>
                                <p>Поставщики</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cubes nav-icon"></i>
                        <p>
                            Отделы
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="shifts" class="nav-link">                                
                                <i class="fas fa-exchange-alt"></i>
                                <p>Смены</p>
                            </a>
                        </li>                       
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>