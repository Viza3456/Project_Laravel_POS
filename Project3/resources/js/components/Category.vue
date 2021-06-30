<template>
    <div style = "width: 115%;">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title mt-3">About Category</h3>
                <div class="card-tools mt-3">
                    <div class="input-group input-group-sm" style="width: 230px;">
                        <input type="text" v-model = "form1.searchname" v-on:keyup.enter="searchcate" name="table_search" style = "font-size : 14px;height: 35px;"  class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="button" @click = "searchcate" class="btn btn-default" style = "color: white;background: rgb(255, 78, 69);">
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
                            <th>DateTime_Create</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for = "cate in category.data" :key = "cate.id">
                            <td>{{cate.id}}</td>
                            <td>{{cate.name}}</td>
                            <td>{{format(cate.created_at)}}</td>
                            <td><button type="button" class = "btn btn-info btn-sm" @click = "upcate(cate)"><i class="fas fa-pencil-alt" style = "color : #fff"></i></button> <button type="button" class  ="btn btn-danger btn-sm" @click = "del(cate.id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <div class = "card-header">
                    <pagination :data="category" size = "small" align ="right" @pagination-change-page="getResults">
                        <span slot="prev-nav"><i class="fas fa-arrow-left"></i> Previous</span>
                        <span slot="next-nav">Next <i class="fas fa-arrow-right"></i></span>
                    </pagination>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-lg" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header card-header">
                        <h4 class="modal-title">Update Category</h4>
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
                        <button type="button" class="btn btn-primary" @click = "update"><i class="fas fa-share-square"></i> Update Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props : ['token'],
    data() {
        return {
            category : {},
            form : new Form({
                id : "",
                name : "",
                _token : this.token.value
            }),
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
            axios.get('/category/get?page=' + page)
            .then(response => {
                this.category = response.data;
            })
        },
        format(value){
            return moment(value).format('MMMM Do YYYY, h:mm:ss');
        },
        upcate(item){
            this.form.fill(item);
            $('#modal-lg').modal('show');
        },
        update(){
            this.form.put('/category/update/' + this.form.id)
            .then((result) => {
                Fire.$emit('onchange', this.category.current_page);
                $('#modal-lg').modal('hide');
                Vue.swal({
                    icon: 'success',
                    title: 'Your Category has been saved',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            }).catch((err) => {
                console.log('tag', 'error');
            });
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
                    this.form.delete('/category/delete/' + id)
                    .then((result) => {
                        Fire.$emit('onchange', this.category.current_page);
                    }).catch((err) => {
                        console.log('tag', 'error');
                    });
                }
            });
        },
        searchcate(){
            this.form1.post('/category/search')
            .then((result) => {
                this.form1.searchname = "";
                this.category = result;
            }).catch((err) => {
                
            });
        },
    },
}
</script>
<style scope>
    
</style>