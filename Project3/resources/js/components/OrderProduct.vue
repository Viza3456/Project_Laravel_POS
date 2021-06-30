<template>
  <div style = "width: 115%;">
    <div style = "border-bottom: 2px solid red;">
      <button type="button"style = "border-radius: 0;"@click = "Ppro" class="btn btn-success btn-lg"><i class="fas fa-upload"></i> Post Product</button>
      <button type="button" class="btn btn-success btn-lg" @click = "Pcate" style = "border-radius: 0;"><i class="fas fa-upload"></i> Post Category</button>
    </div>
    <div class="form-inline mt-3 btn-block">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" v-on:keyup.enter = "searchnp" v-model = "form2.searchname" style = "font-size: 14px;background: white;height: 40px;" type="search" placeholder="Search Product Name" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click = "searchnp" style = "background: rgb(255, 78, 69);width: 40px; color: white;font-weight: 600;" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <div class = "row">
      <div class = "col-md-6">
        <label><i class="fas fa-calendar-check"></i> Select Category Product</label>
        <multiselect v-model="selectC" :options="PushCate" :custom-label = "labelCate" placeholder="Select Category Product"></multiselect>
        <div class  ="mt-1">
          <pagination :data="product" size = "small" align ="left" @pagination-change-page="getResults">
            <span slot="prev-nav"><i class="fas fa-arrow-left"></i> Previous</span>
            <span slot="next-nav">Next <i class="fas fa-arrow-right"></i></span>
          </pagination>
        </div>
        <div>
          <div v-for = "pro in getP" :key = "pro.id" style = "float : left;margin-left: 3px;">
            <div class = "prohover description-block">
              <div class = "description-text"style = "background: rgb(255, 78, 69);padding-top: 5px;">
                <label style = "color: white;">{{pro.name}}</label>
              </div>
              <div>
                <img :src= " 'product/img/' + pro.photo" @click = "buy(pro)" style = "width: 150px;height: 150px;border: 3px solid black;" class = "img-fluid" alt="">
              </div>
              <div style = "background: rgb(255, 78, 69);padding-top: 5px;">
                <label style = "color: white;">$ {{pro.price}}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Product Order</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for = "order in orderproduct">
                  <td>{{order.id}}</td>
                  <td>{{order.name}}</td>
                  <td>{{order.qty}}</td>
                  <td>$ {{order.price}}</td>
                  <td>$ {{order.qty * order.price}} <button type="button" @click = "buy(order)" class = "btn btn-success btn-flat"><i class="fas fa-arrow-circle-up"></i></button> <button type="button" @click = "minus(order)" class = "btn btn-danger btn-flat"><i class="fas fa-arrow-circle-down"></i></button></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th  colspan = "5" style = "color : rgb(255, 78, 69);font-size: 19px;">TotalPay : $ {{total}}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div>
            <button type="button"@click = "Payment" class="btn btn-success btn-lg mt-3 mb-3 pay">TotalPay : $ {{total.toLocaleString()}} <br><i class="fas fa-shopping-cart"></i>  Click To Pay</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-lg" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header card-header">
            <h4 class="modal-title">Post Category</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="fas fa-window-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <form @keydown= "form.onKeydown($event)">
                <div class = "form-group">
                  <input type="text" :class="{ 'is-invalid': form.errors.has('name') }"  v-model = "form.name" name = "name" class="form-control" id="text" placeholder="Category Product">
                  <has-error :form="form" field="name"></has-error>
                </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default Cl" data-dismiss="modal">Close</button>
            <button type="button"@click = "categoryP" class="btn btn-primary"><i class="fas fa-share-square"></i> Post Now</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-lg-pro" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header card-header">
            <h4 class="modal-title">Post Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="fas fa-window-close"></i>
            </button>
          </div>
          <form @keydown="form.onKeydown($event)">
            <div class="modal-body row">
              <div class = "col-md-6">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" v-model = "form.name" name = "name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" placeholder="Product Name">
                      <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                      <label>Price</label>
                      <input type="text" v-model = "form.price" name = "price" :class="{ 'is-invalid': form.errors.has('price') }" class="form-control" placeholder="Price">
                      <has-error :form="form" field="price"></has-error>
                    </div>
                    <div class="form-group">
                      <label>Select Category</label>
                      <multiselect v-model="selectC"name = "category" :options="category":class="{ 'is-invalid': form.errors.has('category') }" :custom-label = "labelCate" placeholder="Select Category Product"></multiselect>
                      <has-error :form="form" field="category"></has-error>
                    </div>
                  </div>
              </div>
              <div class = "card-body col-md-6">
                <div class="form-group">
                  <button type="button"@click = "fillload" class="btn btn-block btn-danger btn-flat"><i class="fas fa-photo-video"></i> Photo</button>
                  <div class="input-group">
                    <div class="custom-file" style = "height: 0;">
                      <input type="file" name = "photo" style = "width : 0;height : 300px;" @change = "imgproduct" class="custom-file-input" id="postproduct1">
                    </div>
                  </div>
                  <img v-bind:src= "form.photo" :class="{ 'is-invalid': form.errors.has('photo') }" style = "width : 100% ;height: 207px;">
                  <has-error :form="form" field="photo"></has-error>
                </div>
              </div>
            </div>
          </form>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default Cl" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click = "postproduct"><i class="fas fa-share-square"></i> Post Now</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-lg-pay" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header card-header">
            <h4 class="modal-title">Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="fas fa-window-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class = "row">
                <div class="form-group col-md-6">
                  <label>Total</label>
                  <input type="number" v-model = "total.toFixed(2)"   :class="{ 'is-invalid': form3.errors.has('total') }" class="form-control f_pay" style = "background: #e6e6e6;" placeholder="Total">
                  <has-error :form="form3" field="total"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <label>Discount %</label>
                  <input type="number" v-model = "discount":class="{ 'is-invalid': form3.errors.has('discount') }" class="form-control f_pay" placeholder="Discount">
                   <has-error :form="form3" field="discount"></has-error>
                </div>
                <div class="form-group col-md-12">
                  <label>Totally</label>
                  <input type="number" v-model = "totally.toFixed(2)":class="{ 'is-invalid': form3.errors.has('totally') }" class="form-control f_pay"style = "background: #e6e6e6;" placeholder="Totally">
                  <has-error :form="form3" field="totally"></has-error>
                </div>
                <div class="form-group col-md-12">
                  <label>Cash In</label>
                  <input type="number" v-model = "cashin"   :class="{ 'is-invalid': form3.errors.has('cashin') }" class="form-control f_pay" placeholder="Cash In">
                  <has-error :form="form3" field="cashin"></has-error>
                </div>
                <div class="form-group col-md-12">
                  <label>Cash Out</label>
                  <input type="number" v-model = "cashout.toFixed(2)" class="form-control f_pay"style = "background: #e6e6e6;" placeholder="Cash Out">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default Cl" data-dismiss="modal">Close</button>
            <button type="button" @click = "ordernow" class="btn btn-primary"><i class="fas fa-share-square"></i> Order Now</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import bsCustomFileInput from 'bs-custom-file-input'
export default {
    props : ['token','category'],
    data() {
      return {
        selectC : {
          id : "",
          name : ""
        },
        form : new Form({
          name : "",
          _token : this.token.value
        }),
        form : new Form({
          name : "",
          price : "",
          photo : "",
          category : "",
          _token : this.token.value
        }),
        product : {},
        form2 : new Form({
          searchname : ""
        }),
        orderproduct : [],
        total : 0,
        discount : 0,
        totally : 0,
        cashin : 0,
        cashout : 0,
        form3 : new Form(),
      }
    },
    mounted() {
      Fire.$on('onchange' , (page = 1) => {
          this.getResults(page);
      });
      this.imgchange();
      this.getResults();
    },
    methods: {
      Pcate(){
        $('#modal-lg').modal('show');
      },
      Ppro(){
        $('#modal-lg-pro').modal('show');
      },
      Payment(){
        this.totally = 0;
        this.discount = 0;
        this.totally = this.totally + this.total;
        $('#modal-lg-pay').modal('show');
      },
      categoryP(){
        this.form.post('/category/post')
        .then((result) => {
          Vue.swal({
              icon: 'success',
              title: 'Your Category has been saved',
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 2000
          });
          $('#modal-lg').modal('hide');
        }).catch((err) => {
          console.log('tag', 'Eror');
        });
      },
      labelCate({name}){
        return `${name}`;
      },
      imgchange() {
        bsCustomFileInput.init()
      },
      imgproduct(event) {
        var eve = event.target.files;
        if (!eve.length) return;
        var reader = new FileReader();
        reader.onload = (file) => {
          this.form.photo = file.target.result;
        };
        reader.readAsDataURL(eve[0]);
      },
      postproduct(){
        this.form.category = this.selectC.id;
        this.form.post('/product/post')
        .then((result) => {
          Vue.swal({
            icon: 'success',
            title: 'Your Product has been saved',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
          });
          Fire.$emit('onchange', this.product.current_page);
          $('#modal-lg-pro').modal('hide');
        }).catch((err) => {
          console.log('tag', 'eror')
        });
      },
      fillload(){
        $('#postproduct1').trigger('click');
      },
      getResults(page = 1) {
        axios.get('/product/get?page=' + page)
          .then(response => {
            this.product = response.data;
          });
		  },
      searchnp(){
        this.form2.post('/product/search')
        .then((result) => {
          this.form2.searchname = "";
          this.product = result;
        }).catch((err) => {
        });
      },
      buy(pro){
        var index = this.orderproduct.findIndex(item => item.id == pro.id);
        if(index != -1){
          this.orderproduct[index].qty++;
          this.total = this.total + parseInt(pro.price);
        }
        else{
          this.orderproduct.push({
            id : pro.id,
            name : pro.name,
            price : pro.price,
            qty : 1
          });
          this.total = this.total + parseInt(pro.price);
        }
      },
      ordernow(){
        this.form3 = new Form({
          total : this.total,
          discount : this.discount,
          totally : this.totally,
          cashin : this.cashin,
          cashout : this.cashout,
          order : this.orderproduct,
          _token : this.token.value
        });
        this.form3.post('/orderproduct/order')
        .then((result) => {
          Vue.swal({
            icon: 'success',
            title: 'Order Product Successfully',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
          });
          $('#modal-lg-pay').modal('hide');
        }).catch((err) => {
          
        });
      },
      minus(pro){
        var index = this.orderproduct.findIndex(item => item.id == pro.id);
        if(pro.qty > 1){
          this.orderproduct[index].qty--;
          this.total = this.total - parseInt(pro.price);
        }
        else {
          this.orderproduct = this.orderproduct.filter(item => item.id != pro.id);
          this.total = this.total - parseInt(pro.price);
        }
      },
    },
    computed : {
      getP(){
        if(this.selectC.id != ""){
          var pro = this.product.data.filter(item => item.category == this.selectC.id);
          return pro;
        }
        return this.product.data;
      },
      PushCate(){
        var result = [{
          id : "",
          name : "All"
        }];
        for(var i = 0; i < this.category.length; i++){
            var item  = this.category[i];
            result.push({
              id : item.id,
              name : item.name
            });
        }
        return result;
      },
    },
    watch : {
      discount : function (value) {
        if(value <= 100 && value >= 0){
          this.totally =  this.total - (this.total * value)/100;
          this.cashout = this.cashin - this.totally;
        }
      },
      cashin : function (value){
        if(value >= this.totally){
          this.cashout = value - this.totally;
        }
        else if(value >= 1){
          this.cashout = value - this.totally;
        }
        else{
          this.cashout = 0;
        }
      }
    }
}
</script>
<style scope>
  .multiselect__tags{
    height: 40px;
  }
  .pay{
    border: 3px solid yellow;
    background : rgb(255, 78, 69);
    border-radius: 0;
    margin-left : 68%;
  }
  .pay i{
    font-size: 30px;
  }
  .Cl{
    background : rgb(255, 78, 69);
    font-weight : 600;
    color : white;
  }
  .fa-window-close{
    font-size : 27px;
  }
  .prohover{
    width : 100%;
    transition : .3s;
  }
  .prohover:hover{
    width : 97%;
  }
  .form-control{
    font-size: 14px;
    background: white;
    height: 40px;
  }
  .f_pay{
    font-size: 20px;
    height: 60px;
  }
  .modal-content{
    border: 2px solid rgb(255, 78, 69);
  }
  /* .swal2-show {
    height: 130px;
    width: 30%;
    padding-top: 15px;
    border-radius: 3px;
  } 
  .swal2-header {
    font-size: 10px;
  } */
</style>