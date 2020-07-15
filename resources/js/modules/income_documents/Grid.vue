<template>
<div class=card>    
    <div class="card-header">
        <div class="cart-title">
            <p>Income Documents</p>
            <button type="button" 
                    class="btn  btn-outline-primary btn-flat" 
                    data-toggle="modal" 
                    data-target="#modal-default"
                    data-backdrop="static" 
                    data-keyboard="true">
                <i class="fas fa-plus"></i>
                    Добавить
            </button> 
        </div> 
    </div>
    <div class="card-body">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div id="row_count__wrapper">
              <label>
                Show
                <select name="row_count" id="row_count" class="custom-select custom-select-sm form-control form-control-sm">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="all">All</option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div id="filter" class="database_filter">
              <label>
                Search
                <input type="search" class="form-control form-control-sm" placeholder="">
              </label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">№</th>
                    <th scope="col">Поставщик</th>
                    <th scope="col">Отдел</th>
                    <th scope="col">Сотрудник</th>
                    <th scope="col">Сумма закупки</th>
                    <th scope="col">Сумма с наценкой</th>                    
                    <th scope="col">Наценка</th>                    
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="document in documents" :key="document.id">
                    <td>{{document.date}}</td> 
                    <td><router-link :to="{name: 'IncomeDocumentsShow', params: {id: document.id}}">{{document.number}}</router-link></td>                                              
                    <td>{{document.supplier}}</td>
                    <td>{{document.department}}</td>
                    <td>{{document.employee_full_name}}</td>
                    <td>{{document.sum1}}</td>
                    <td>{{document.sum2}}</td>                    
                    <td>{{document.gain}}</td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
    </div>
   
</div>
    
</template>

<script>
export default {
    name: 'IncomeDocumentsGrid',
    props: ['documents'],
    data() {
        return {
          document: {
            date: null,
            supplier_id: 0,
            department_id: 0,
            sum1: 0,
            sum2: 0
          },          
          suppliers: [],
          departments: []
        }
    },
    methods: {
      closeModal() {
        this.document.date = null;
        this.document.supplier_id = 0;
        this.document.department_id = 0;
        this.document.sum1 = 0;
        this.document.sum2 = 0;
      },
      getSuppliersDictionary() {
        this.getDictionaryForSelect('suppliers')
            .then(res => this.suppliers = res);
      },
      getDepartmentsDictionary() {
        this.getDictionaryForSelect('departments')
            .then(res => this.departments = res);
      },
      
      getDictionaryForSelect(dictionary) {
         return axios.get(`/api/select-dictionary/${dictionary}`, 
                    {
                        'headers': {
                            'Authorization': 'Bearer ' + window.api_token,
                            'Accept': 'application/json',
                        } 
                    }
                )
                .then(res => res.data)
                .catch(err => console.log(err));
      }
    },
    created() {
      this.getSuppliersDictionary();
      this.getDepartmentsDictionary();
    }
}        
</script>