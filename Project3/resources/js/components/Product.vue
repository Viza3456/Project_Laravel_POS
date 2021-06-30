<template>
  <div style = "width: 115%;">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mt-3">About Product</h3>
        <div class="card-tools mt-3">
          <div class="input-group input-group-sm" style="width: 230px;">
            <input type="text" name="searchname"v-model = "form1.searchname" v-on:keyup.enter="searchcate" style = "font-size : 14px;height: 35px;"  class="form-control float-right" placeholder="Search">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default"@click = "searchcate" style = "color: white;background: rgb(255, 78, 69);">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Photo</th>
              <th>Price</th>
              <th>Category</th>
              <th>DateTime_Create</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for = "pro in product.data" :key = "pro.id">
              <td>{{pro.id}}</td>
              <td>{{pro.name}}</td>
              <td>
                <ul class="list-inline">
                  <li class="list-inline-item">
                    <img alt="photo" class="table-avatar" :src= " 'product/img/' + pro.photo">
                  </li>
                </ul>
              </td>
              <td>$ {{pro.price}}</td>
              <td>{{pro.category}}</td>
              <td>{{format(pro.created_at)}}</td>
              <td><button type="button" @click = "edit(pro)" class = "btn btn-info btn-sm"><i class="fas fa-pencil-alt" style = "color : #fff"></i></button> <button type="button" @click = "del(pro.id)"  class  ="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></td>
            </tr>
          </tbody>
        </table>
        <div class = "card-header">
          <pagination :data="product" size = "small" align ="right" @pagination-change-page="getResults">
            <span slot="prev-nav"><i class="fas fa-arrow-left"></i> Previous</span>
            <span slot="next-nav">Next <i class="fas fa-arrow-right"></i></span>
          </pagination>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-lg-pro" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header card-header">
            <h4 class="modal-title">Update Product</h4>
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
                    <input type="text" name = "price" v-model = "form.price" :class="{ 'is-invalid': form.errors.has('price') }" class="form-control" placeholder="Price">
                    <has-error :form="form" field="price"></has-error>
                  </div>
                  <div class="form-group">
                    <label>Select Category</label>
                    <multiselect v-model="selectC" name = "category" :options="category":class="{ 'is-invalid': form.errors.has('category') }" :custom-label = "labelCate" placeholder="Select Category Product"></multiselect>
                    <has-error :form="form" field="category"></has-error>
                  </div>
                </div>
              </div>
              <div class = "card-body col-md-6 mt-3">
                <div class="form-group mt-3">
                  <img v-bind:src= "up ? 'product/img/' + form.photo : '' " :class="{ 'is-invalid': form.errors.has('photo') }" style = "width : 100% ;height: 212px;">
                  <has-error :form="form" field="photo"></has-error>
                </div>
              </div>
            </div>
          </form>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default Cl" data-dismiss="modal">Close</button>
            <button type="button" @click = "update" class="btn btn-primary"><i class="fas fa-share-square"></i> Update Now</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment';
export default {
    props : ['token','category'],
    data() {
        return {
            selectC : {
              id : "",
              name : ""
            },
            product : {},
            form : new Form({
              id : "",
              name : "",
              price : "",
              photo : "",
              category : "",
              _token : this.token.value
            }),
            up : false,
            form1 : new Form({
                searchname : "",
            }),
        }
    },
    mounted() {
        Fire.$on('onchange' , (page = 1) =>{
          this.getResults(page);
        })
        this.getResults();
    },
    methods: {
      getResults(page = 1) {
        axios.get('/product/get?page=' + page)
          .then(response => {
            this.product = response.data;
          })
      },
      format(value){
        return moment(value).format('MMMM Do YYYY, h:mm:ss');
      },
      labelCate({name}){
        return `${name}`;
      },
      edit(pro){
        this.form.fill(pro);
        this.up = true;
        this.selectC = this.category.find(({id}) => id == pro.category);
        $('#modal-lg-pro').modal('show');
      },
      update(){
        this.form.category = this.selectC.id;
        this.form.put('/productitem/update/' + this.form.id)
        .then((result) => {
          Vue.swal({
            icon: 'success',
            title: 'Your Product has been saved',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
          });
          Fire.$emit('onchange' , this.product.current_page);
          $('#modal-lg-pro').modal('hide');
        }).catch((err) => {
          console.info('tag', 'error');
        });
      },
      searchcate(){
        this.form1.post('/productitem/search')
        .then((result) => {
          // this.form1.searchname = "";
          this.product = result;
        })
      },
      del(id){
        Vue.swal({
          title: 'Are you sure?',
          text: "You can delete this record!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.isConfirmed) {
              Vue.swal(
                'Deleted!',
                'Your Category has been deleted.',
                'success'
              )
              this.form.delete('/productitem/delete/' + id)
                .then((result) => {
                  Fire.$emit('onchange', this.product.current_page);
                }).catch((err) => {
                  console.log('tag', 'error');
                });
              }
        });
      },
    },
}
</script>
<style scope>
    
</style>