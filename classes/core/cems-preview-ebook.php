<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSPreviewEbook template
 *
 * @class           CEMSPreviewEbook
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-07-15
 * @version         1.0.0
 *
 */
class CEMSPreviewEbook {

    /**
     * List ID
     *
     * @brief List ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Book Title
     *
     * @brief Book Title
     *
     * @var int $book_title
     */
    public $book_title = '';

    /**
     * Create an instance of CEMSPreviewEbook class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSPreviewEbook
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $list_id ) ) {
            $this->list_id=$list_id;
        }
        if ( !empty( $book_title ) ) {
            $this->book_title=$book_title;
        }
    }

    /**
     * Display preview button
     *
     * @brief Display
     */
    public function display()
    {
        echo $this->html();
    }

    /**
     * Return the HTML markup for the preview button
     *
     * @brief HTML markup preview button
     *
     * @return string
     */
    public function html()
    {
        WPDKHTML::startCompress();
        //#TODO: Bootstrap things come with CEMSTheme should only loaded here
        ?>
        <div class="panel panel-default cems-preview-ebook-panel">
            <div class="panel-body">
                <button type="button" class="center-block btn btn-primary" data-toggle="collapse" data-target="#ebook-subscription">
                    Tải về b đọc thử sách <span id="book-title-request"><?php echo $this->book_title;?></span> (giống sách in 100%)
                </button>
                <p></p>
                <div id="ebook-subscription" class="collapse">
                    <p>Bạn đã đăng ký email để tải thông tin trên trang TGM Books chưa?</p>
                    <div class="alert alert-danger alert-dismissible" role="alert" id="cems-alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Đóng</span>
                        </button>
                        <div class="error-response"></div>
                    </div>
                    <div class="panel-group" id="cems-accordion1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#cems-accordion1" href="#collapseSubscriptionForm">
                                        <?php echo __('Tôi đã đăng ký email',WPCEMS_TEXTDOMAIN);?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSubscriptionForm" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form role="form" class="form-inline" name="subscription-form" id="subscription-form" method="post" >
                                        <div class="alert alert-info" role="alert"><?php echo __('Vui lòng nhập lại địa chỉ email bạn đã đăng ký',WPCEMS_TEXTDOMAIN);?></div>
                                        <div class="form-group">
                                            <label for="subscription-email"><?php echo __('
Địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <input type="email" class="form-control" id="subscription-email" name="subscriptionEmail" placeholder="<?php echo __('Nhập địa chỉ email',WPCEMS_TEXTDOMAIN);?>" required>
                                            <input type="hidden" class="hidden" name="listId" value="<?php echo $this->list_id;?>"/>
                                        </div>
                                        <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-subscription"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#cems-accordion1" href="#collapseCustomerForm">
                                        <?php echo __('Tôi chưa đăng ký email',WPCEMS_TEXTDOMAIN);?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCustomerForm" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form role="form" name="customer-form" id='customer-form' method="post" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="customer-name" class="col-sm-3 control-label"><?php echo __('
Họ tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="customer-name" name="customerName" placeholder="<?php echo __('Nhập họ và tên',WPCEMS_TEXTDOMAIN);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-province" class="col-sm-3 control-label"><?php echo __('
Tỉnh thành',WPCEMS_TEXTDOMAIN);?></label>
                                            <div class="col-sm-9">
                                                <select class="chosen-select" id="customer-province" name="customerProvince">
                                                        <option value="An Giang">An Giang</option>
                                                        <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                                                        <option value="Bắc Cạn">Bắc Cạn</option>
                                                        <option value="Bắc Giang">Bắc Giang</option>
                                                        <option value="Bạc Liêu">Bạc Liêu</option>
                                                        <option value="Bắc Ninh">Bắc Ninh</option>
                                                        <option value="Bến Tre">Bến Tre</option>
                                                        <option value="Bình Dương">Bình Dương</option>
                                                        <option value="Bình Định">Bình Định</option>
                                                        <option value="Bình Phước">Bình Phước</option>
                                                        <option value="Bình Thuận">Bình Thuận</option>
                                                        <option value="Cà Mau">Cà Mau</option>
                                                        <option value="Cần Thơ">Cần Thơ</option>
                                                        <option value="Cao Bằng">Cao Bằng</option>
                                                        <option value="Đà Nẵng">Đà Nẵng</option>
                                                        <option value="Đắk Lắk">Đắk Lắk</option>
                                                        <option value="Đắk Nông">Đắk Nông</option>
                                                        <option value="Điện Biên">Điện Biên</option>
                                                        <option value="Đồng Nai">Đồng Nai</option>
                                                        <option value="Đồng Tháp">Đồng Tháp</option>
                                                        <option value="Gia Lai">Gia Lai</option>
                                                        <option value="Hà Giang">Hà Giang</option>
                                                        <option value="Hà Nam">Hà Nam</option>
                                                        <option value="Hà Nội">Hà Nội</option>
                                                        <option value="Hà Tĩnh">Hà Tĩnh</option>
                                                        <option value="Hải Dương">Hải Dương</option>
                                                        <option value="Hải Phòng">Hải Phòng</option>
                                                        <option value="Hậu Giang">Hậu Giang</option>
                                                        <option value="Hồ Chí Minh" selected>TP Hồ Chí Minh</option>
                                                        <option value="Hòa Bình">Hòa Bình</option>
                                                        <option value="Hưng Yên">Hưng Yên</option>
                                                        <option value="Khánh Hoà">Khánh Hoà</option>
                                                        <option value="Kiên Giang">Kiên Giang</option>
                                                        <option value="Kon Tum">Kon Tum</option>
                                                        <option value="Lai Châu">Lai Châu</option>
                                                        <option value="Lâm Đồng">Lâm Đồng</option>
                                                        <option value="Lạng Sơn">Lạng Sơn</option>
                                                        <option value="Lào Cai">Lào Cai</option>
                                                        <option value="Long An">Long An</option>
                                                        <option value="Nam Định">Nam Định</option>
                                                        <option value="Nghệ An">Nghệ An</option>
                                                        <option value="Ninh Bình">Ninh Bình</option>
                                                        <option value="Ninh Thuận">Ninh Thuận</option>
                                                        <option value="Phú Thọ">Phú Thọ</option>
                                                        <option value="Phú Yên">Phú Yên</option>
                                                        <option value="Quảng Bình">Quảng Bình</option>
                                                        <option value="Quảng Nam">Quảng Nam</option>
                                                        <option value="Quảng Ngãi">Quảng Ngãi</option>
                                                        <option value="Quảng Ninh">Quảng Ninh</option>
                                                        <option value="Quảng Trị">Quảng Trị</option>
                                                        <option value="Sóc Trăng">Sóc Trăng</option>
                                                        <option value="Sơn La">Sơn La</option>
                                                        <option value="Tây Ninh">Tây Ninh</option>
                                                        <option value="Thái Bình">Thái Bình</option>
                                                        <option value="Thái Nguyên">Thái Nguyên</option>
                                                        <option value="Thanh Hoá">Thanh Hoá</option>
                                                        <option value="Thừa Thiên - Huế">Thừa Thiên - Huế</option>
                                                        <option value="Tiền Giang">Tiền Giang</option>
                                                        <option value="Trà Vinh">Trà Vinh</option>
                                                        <option value="Tuyên Quang">Tuyên Quang</option>
                                                        <option value="Vĩnh Long">Vĩnh Long</option>
                                                        <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                                                        <option value="Yên Bái">Yên Bái</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="customer-email" name="customerEmail" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-phone" class="col-sm-3 control-label"><?php echo __('
Số điện thoại',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="tel" class="form-control" id="customer-phone" name="customerPhone" placeholder="<?php echo __('Nhập số điện thoại của bạn',WPCEMS_TEXTDOMAIN);?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-reading" class="col-sm-5">Bạn thích đọc loại sách nào?<br><span class="help-block">(có thể chọn nhiều loại)</span></label>
                                            <div class="col-sm-7 checkbox" id="customer-reading">
                                                    <label for="customer-reading-1">
                                                        <input id="customer-reading-1" type="checkbox" class="loaisach" name="customerReading[]" value="Phát triển bản thân và kỹ năng">Phát triển bản thân và kỹ năng.
                                                    </label>
                                                    <label for="customer-reading-2">
                                                        <input id="customer-reading-2" type="checkbox" class="loaisach" name="customerReading[]" value="Kinh doanh & đầu tư">Kinh doanh &amp; đầu tư
                                                    </label>
                                                    <label for="customer-reading-3">
                                                        <input id="customer-reading-3" type="checkbox" class="loaisach" name="customerReading[]" value="Các mối quan hệ gia đình và con cái">Các mối quan hệ gia đình và con cái.
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Ghi chú:</strong> Chúng tôi sẽ gửi thông tin đến địa chỉ email mà bạn đăng ký. Vui lòng nhập email chính xác.
                                        </div>
                                        <input type="hidden" class="hidden" name="listId" value="<?php echo $this->list_id;?>"/>
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-5">
                                                <button data-loading-text="Đang gửi ..." type="submit" class="center-block btn btn-primary" id="btn-new-customer"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $content = WPDKHTML::endHTMLCompress();
        return $content;
    }
}