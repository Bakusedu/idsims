<template>
  <div>
        <div class="bg-footer">
            <div class="container-fluid">
                <div class="col-md-12 pt-4 pb-4">
                    <div class="row">
                        <div class="col-md-2 col-12 border-right">
                            <div class="text-center">
                                <h2 style="font-weight:bolder">IDSIMS</h2>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 margin-bottom">
                            <ul>

                                <li>
                                    <span>Drugs</span>
                                </li>
                                <li>
                                    <span>About us</span>
                                </li>
                                <li>
                                    <span>Learn more</span>
                                </li>
                                <li>
                                    <span>Developers</span>
                                </li>
                                <li>
                                    <span>Hiring</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 col-6">
                            <ul>
                                <li>
                                    <span>Project</span>
                                </li>
                                <li>
                                    <span>Contact us</span>
                                </li>
                                <li>
                                    <span>Terms and conditions</span>
                                </li>
                                <li>
                                    <span>Privacy policy</span>
                                </li>
                                <li>
                                    <span>FAQ</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-12 pr-0">
                            <div class="float_right">
                                <p><span><i id="chevron-up" class="fa fa-chevron-up"></i></span></p>
                            </div>
                            <p id="fs-16" class="mb-2 mt-1">Sign up to our news letter</p>
                            <div class="row">
                                <div class="col-md-8 col-12 d-flex">
                                    <div class="mr-1">
                                        <input type="text" class="form-control" name="news">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-p">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <p class="text-center">Copyright &copy; 2020  All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
   .bg-footer {
        background-color:#0062b2;
    }
    .footer-padding {
        padding: 0 50px;
    }
    .border-right {
        border-right: 1px solid grey;
    }
    ul li {
        list-style:none;
        font-size:15px;
    }
    #fs-16 {
        font-size:20px;
    }
    #chevron-up {
        color:white;
        background-color:#0062b2;
        font-size: 20px;
        border-radius: 6px;
        height:40px;
        width:40px;
        line-height:40px;
    }
    .float_right {
        position:absolute;
        right:0px;
    }
    #social-icons span img {
          width:20px;
          height:20px;
      }
    @media (min-width: 100px) and (max-width: 768px){
      #social-icons span img {
          width:15px;
          height:15px;
      }
      .border-right {
          border-right: none !important;
      }
      .margin-bottom {
          margin-bottom:8px;
      }
    }
</style>