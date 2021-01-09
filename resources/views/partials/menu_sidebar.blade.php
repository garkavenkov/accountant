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
                        <li class="nav-item">
                            <a href="transfer-documents" class="nav-link">                                
                                <i class="fas fa-dolly nav-icon"></i>                                
                                <p>Трансферные накладные</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="expense-documents" class="nav-link">                                
                                <i class="fas fa-share-alt nav-icon"></i>
                                <p>Расходые накладные</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="markdown-documents" class="nav-link">
                                <i class="fas fa-file-download nav-icon"></i>
                                <p>Уценка товара</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="writedown-documents" class="nav-link">
                                <i class="fas fa-file-export nav-icon"></i>
                                <p>Списание товара</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="return-documents" class="nav-link">
                                <i class="fas fa-file-prescription nav-icon"></i>
                                <p>Возврат товара</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="markup-documents" class="nav-link">
                                <i class="fas fa-file-upload nav-icon"></i>
                                <p>Дооценка товара</p>
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
                        <li class="nav-item">
                            <a href="salaries" class="nav-link">
                                <i class="fas fa-coins"></i>
                                <p>Зарплата</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="accountabilities" class="nav-link">
                                <i class="fas fa-coins"></i>
                                <p>Подотчетные документы</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cash-expense-documents" class="nav-link">
                                <i class="fas fa-coins"></i>
                                <p>Расходные кассовые документы</p>
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
                                <i class="fas fa-exchange-alt  nav-icon"></i>
                                <p>Смены</p>
                            </a>
                        </li>                       
                        
                        <li class="nav-item">
                            <a href="department-turns" class="nav-link">                                
                                <i class="fas fa-dolly-flatbed nav-icon"></i>
                                <!-- <i class="fas fa-exchange-alt"></i> -->
                                <p>Обороты и остатки</p>
                            </a>
                        </li>                       
                    </ul>

                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-toolbox nav-icon"></i>
                        <p>
                            Настройки
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="shifts" class="nav-link">                                
                                <i class="fas fas fa-tools nav-icon"></i>
                                <p>Системные справочники</p>
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