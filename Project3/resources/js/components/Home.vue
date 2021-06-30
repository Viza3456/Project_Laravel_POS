<template>
    <div style = "width: 115%;">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner" v-for = "user in use">
                        <h3>{{user.User_Count}}</h3>
                        <p>User</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner" v-for = "pros in pro">
                        <h3>{{pros.Product_Count}}</h3>
                        <p>Product</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner" v-for = "cats in cate">
                        <h3>{{cats.Category_Count}}</h3>
                        <p>Category Product</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner" v-for = "ords in ord">
                        <h3>{{ords.Order_Count}}</h3>
                        <p>Order Product</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title mt-3">About Order</h3>
                <div class="card-tools mt-3">
                    <div class="input-group input-group-sm" style="width: 230px;">
                        <input type="text" name="table_search"v-model = "form1.SOrderID" v-on:keyup.enter="searchID" style = "font-size : 14px;height: 35px;"  class="form-control float-right" placeholder="Search ID Order">
                        <div class="input-group-append">
                        <button type="button" class="btn btn-default" @click = "searchID" style = "color: white;background: rgb(255, 78, 69);">
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
                            <th>ID Product</th>
                            <th>ID Order</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Discount</th>
                            <th>Discount Money</th>
                            <th>Total</th>
                            <th>TotalPay</th>
                            <th>Cash In</th>
                            <th>Cash Out</th>
                            <th>DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for = "ordsh in orderdata.data">
                            <td>{{ordsh.product_id}}</td>
                            <td>{{ordsh.pay_order_id}}</td>
                            <td>{{ordsh.name}}</td>
                            <td>$ {{ordsh.price}}</td>
                            <td>{{ordsh.qty}}</td>
                            <td>{{ordsh.discount}} %</td>
                            <td>$ {{((ordsh.price * ordsh.qty) * ordsh.discount)/100}}</td>
                            <td>$ {{(ordsh.price * ordsh.qty) - (((ordsh.price * ordsh.qty) * ordsh.discount)/100)}}</td>
                            <td>$ {{ordsh.total_pay}}</td>
                            <td>$ {{ordsh.cash_in}}</td>
                            <td>$ {{ordsh.cash_out}}</td>
                            <td>{{format(ordsh.datetime)}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class = "card-header">
                    <pagination :data="orderdata" size = "small" align ="right" @pagination-change-page="getResults">
                        <span slot="prev-nav"><i class="fas fa-arrow-left"></i> Previous</span>
                        <span slot="next-nav">Next <i class="fas fa-arrow-right"></i></span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props : ['use','pro','cate','ord'],
        data() {
            return {
                orderdata : {},
                form1 : new Form({
                    SOrderID : "",
                }),
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            format(value){
                return moment(value).format('MMMM Do YYYY, h:mm:ss');
            },
            getResults(page = 1) {
                axios.get('/home/show?page=' + page)
                .then(response => {
                    this.orderdata = response.data;
                    console.log('tag', this.orderdata);
                });
            },
            searchID(){
                this.form1.post('/home/SorderID')
                .then((result) => {
                    this.form1.SOrderID = "";
                    this.orderdata = result;
                }).catch((err) => {
                    
                });
            },
            
        },
    }
</script>
