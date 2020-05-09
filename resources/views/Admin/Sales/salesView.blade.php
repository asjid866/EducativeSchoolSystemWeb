@extends('educativeBase')

@section('title', 'Admin-Login')

@section('styleLinks')

@endsection

@section('style')
@endsection

@include('Admin/adminHeader')

@section('content')
    <div class="container" style="padding: 20px">
        <div class="col-lg-12 border border-primary rounded" style="padding: 30px">
            <div class="row" style="padding: 20px">
                <div class="col-12">
                    <h2 class="contact-title">Sales</h2>
                </div>
            </div>
            <form id="studentFeeCollection" method="post" action="admin-saveStudentSales">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="md-form">
                            <label for="class"></label>
                            <select class="custom-select" onchange="classChanged()" id="class" name="class">
                                <option selected disabled>Select Class</option>
                                <option>Play Group</option>
                                <option>Nursury</option>
                                <option>Prep</option>
                                <option>One</option>
                                <option>Two</option>
                                <option>Three</option>
                                <option>Four</option>
                                <option>Five</option>
                                <option>Six</option>
                                <option>Seven</option>
                                <option>Eight</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4" id="studentList">  {{-- Student List from Javascript--}}   </div>
                </div>

                <div class="row">
                    <div class="col-sm-12" id="studentFeeDetails">  {{-- Student List from Javascript--}}   </div>
                </div>
                <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr>

                <div id="productDetails">      {{-- Product details from javascript--}}      </div>

                <input id="totalProducts" name="totalProducts" hidden>

                <div class="form-group row"  style="padding-top: 10px;">

                    <div class="col-sm-4">
                        <div class="md-form">
                            <i class="fas fa-coins prefix"></i>
                            <input class="form-control validate" name="netTotal" id="netTotal" type="number" value="0">
                            <label class="active" for="netTotal">Net Total</label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="md-form">
                            <i class="fas fa-coins prefix"></i>
                            <input class="form-control validate" name="netTotalPaid" id="netTotalPaid" type="number" value="0">
                            <label class="active" for="netTotalPaid">Net Total Paid</label>
                        </div>
                    </div>

                    <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                        <a class="center genric-btn primary circle zoom" onclick="addMoreProduct()">Add More</a>
                        <button type="submit" class="center genric-btn primary circle zoom" onclick="">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>







@endsection

@section('script')
    <script type="text/javascript">
        $numberOfProducts = 0;
        $studentDetails = "";

        function classChanged(){
            $class  = $("#class").val();
            $("#studentList").html('');
            $studentDetails = "";

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/admin-getStudentByClass',
                data:{
                    class: $class
                },
                success:function(data) {
                    $studentDetails = data;
                    $html = "";

                    $html = "                <div class=\"md-form\">\n" +
                        "                    <label for=\"class\"></label>\n" +
                        "                    <select class=\"custom-select\" id=\"selectedStudentId\" name=\"selectedStudentId\">\n" +
                        "                        <option selected disabled>Select Student</option>\n";

                    // $("#studentList").append($html);

                    $(data).each(function (index) {
                        if ($(this)[0].mName != null){
                            $html += "<option value='"+ $(this)[0].studentId+ "'>" + $(this)[0].fName +" "+ $(this)[0].mName +" "+ $(this)[0].lName +"</option>";
                        }
                        else {
                            $html += "<option value='"+ $(this)[0].studentId+ "'>" + $(this)[0].fName +" "+ $(this)[0].lName +"</option>";
                        }
                        // $("#studentList").append($html);
                    });

                    $html += "             </select>\n" +
                        "                </div>\n";
                    $("#studentList").append($html);
                }
            });
        }

        function productChange($id) {
            $id = "#".concat($id).concat("-");
            var $selectedProduct  = $($id.concat("product")).val();
            $($id.concat("quantity")).val('');
            $($id.concat("unitPrice")).val('');
            $($id.concat("total")).val('');

            console.log($selectedProduct);

            var $products = {!! json_encode($products->toArray()) !!};
            $($products).each(function (index) {
                if ($(this)[0].productName == $selectedProduct){
                    netTotalChange();
                    return $($id.concat("unitPrice")).val($(this)[0].productPrice);
                }
            });
        }

        function totalChange($id) {
            $id = "#".concat($id).concat("-");
            var $selectedUnitPrice  = $($id.concat("unitPrice")).val();
            var $selectedQuantity = $($id.concat("quantity")).val();
            return $($id.concat("total")).val($selectedQuantity * $selectedUnitPrice);
        }

        function addMoreProduct() {
            addNewProduct();
        }

        function removeProduct($selectedProductNumber) {
            $selectedProductNumber = "#".concat($selectedProductNumber).concat("-numberedProduct");
            $($selectedProductNumber).remove();
            netTotalChange();
        }


        $(document).ready(function() {
            addNewProduct();
        });

        function netTotalChange() {
            $total = 0;
            for ($i = 0; $i<($numberOfProducts+1); $i++){
                $idd = "#".concat($i).concat("-total");
                if ($($idd).val() != null){
                    $total = parseInt($total) +parseInt($($idd).val());
                }
            }
            $("#netTotal").val($total);
            $total = 0;
        }


        function netTotalPaidChange() {
            console.log('in net paid change');
            $totalPaid = 0;
            for ($i = 0; $i<($numberOfProducts+1); $i++){
                $idd = "#".concat($i).concat("-paidAmount");
                if ($($idd).val() != null){
                    $totalPaid = parseInt($totalPaid) + parseInt($($idd).val());
                }
            }
            $("#netTotalPaid").val($totalPaid);
            $totalPaid = 0;
        }


        function addNewProduct() {
            $html = "              <div id='" + $numberOfProducts +"-numberedProduct'>      <div class=\"row\">\n" +
                "                        <div class=\"col-sm-4\">\n" +
                "                            <div class=\"md-form\">\n" +
                "<i class=\"fas fa-list-ul prefix\"></i>\n" +
                "<input class=\"form-control validate\" type=\"text\"id='" + $numberOfProducts +"-product' name='" + $numberOfProducts +"-product' onchange='productChange(" + $numberOfProducts +");' list=\"productsList\"/>\n" +
                "<datalist id=\"productsList\">\n" +
                "                                    @foreach($products as $product)\n" +
                "                                        <option value=\"{{ $product->productName }}\">{{ $product->productName }}</option>\n" +
                "                                    @endforeach\n" +
                "</datalist>"+
            "                                <label for=\"" + $numberOfProducts +"-product\">Product Name</label>\n" +


                    {{--"                                <select class=\"custom-select\" id='" + $numberOfProducts +"-product' name='" + $numberOfProducts +"-product' onchange='productChange(" + $numberOfProducts +");'>\n" +--}}
                            {{--"                                    <option selected disabled>Select Product</option>\n" +--}}
                            {{--"                                    @foreach($products as $product)\n" +--}}
                            {{--"                                        <option value=\"{{ $product->productName }}\">{{ $product->productName }}</option>\n" +--}}
                            {{--"                                    @endforeach\n" +--}}
                            {{--"                                </select>\n" +--}}
                        "                            </div>\n" +
                "                        </div>\n" +
                "\n" +
                "\n" +
                "                        <div class=\"col-sm-4\">\n" +
                "                            <div class=\"md-form\">\n" +
                "                                <i class=\"fas fa-coins prefix\"></i>\n" +
                "                                <input class=\"form-control validate\" name='" + $numberOfProducts +"-quantity' id='" + $numberOfProducts +"-quantity' oninput=\"totalChange(" + $numberOfProducts +"); netTotalChange()\" type='number'>\n" +
                "                                <label for=\"" + $numberOfProducts +"-quantity\">Quantity</label>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "\n" +
                "                    <div class=\"col-4\" style=\"text-align: right; \">\n" +
                "                        <a class=\"\" onclick=\"removeProduct(" + $numberOfProducts +")\">Remove</a>\n" +
                "                    </div>\n" +

                "                    </div>\n" +
                "\n" +
                "                    <div class=\"row\">\n" +
                "                        <div class=\"col-sm-4\">\n" +
                "                            <div class=\"md-form\">\n" +
                "                                <i class=\"fas fa-coins prefix\"></i>\n" +
                "                                <input class=\"form-control validate\" name='" + $numberOfProducts +"-unitPrice' value=\"0\" id='" + $numberOfProducts +"-unitPrice' oninput=\"totalChange(" + $numberOfProducts +"); netTotalChange()\" type=\"number\">\n" +
                "                                <label class='active' for=\"" + $numberOfProducts +"-unitPrice\">Unit Price</label>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "\n" +
                "                        <div class=\"col-sm-4\">\n" +
                "                            <div class=\"md-form\">\n" +
                "                                <i class=\"fas fa-coins prefix\"></i>\n" +
                "                                <input class=\"form-control validate\" name='" + $numberOfProducts +"-total' value=\"0\" id='" + $numberOfProducts +"-total' oninput='netTotalChange()' type=\"number\">\n" +
                "                                <label class='active' for=\"" + $numberOfProducts +"-total\">Total</label>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "\n" +
                "                        <div class=\"col-sm-4\">\n" +
                "                            <div class=\"md-form\">\n" +
                "                                <i class=\"fas fa-coins prefix\"></i>\n" +
                "                                <input class=\"form-control validate\" name='" + $numberOfProducts +"-paidAmount'  id='" + $numberOfProducts +"-paidAmount' type=\"number\" oninput='netTotalPaidChange()' >\n" +
                "                                <label for=\"" + $numberOfProducts +"-paidAmount\">Paid Amount</label>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                    <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr></div>\n";
            $("#productDetails").append($html);
            $html = "";
            $numberOfProducts++;
            $("#totalProducts").val($numberOfProducts);
        }

    </script>
    @include('footer')
@endsection