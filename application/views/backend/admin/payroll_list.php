<?php echo form_open(site_url('admin/payroll_list/filter'));
echo $_SESSION['data'];
?>
<!-- inicio busquar recibo por fechas  -->
<div class="row">

    <div class="col-md-offset-2 col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;">
                <?php echo get_phrase('month'); ?>
            </label>
            <select name="month" class="form-control selectboxit">
                <?php
                for ($i = 1; $i <= 12; $i++) :
                    if ($i == 1)
                        $m = get_phrase('january');
                    else if ($i == 2)
                        $m = get_phrase('february');
                    else if ($i == 3)
                        $m = get_phrase('march');
                    else if ($i == 4)
                        $m = get_phrase('april');
                    else if ($i == 5)
                        $m = get_phrase('may');
                    else if ($i == 6)
                        $m = get_phrase('june');
                    else if ($i == 7)
                        $m = get_phrase('july');
                    else if ($i == 8)
                        $m = get_phrase('august');
                    else if ($i == 9)
                        $m = get_phrase('september');
                    else if ($i == 10)
                        $m = get_phrase('october');
                    else if ($i == 11)
                        $m = get_phrase('november');
                    else if ($i == 12)
                        $m = get_phrase('december'); ?>

                    <option value="<?php echo $i; ?>" <?php if ($i == $month) echo 'selected'; ?>>
                        <?php echo $m; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;">
                <?php echo get_phrase('year'); ?>
            </label>
            <select name="year" class="form-control selectboxit">
                <?php
                $year_list = array("2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025", "2026");
                foreach ($year_list as $row) { ?>
                    <option value="<?php echo $row; ?>" <?php if ($row == $year) echo 'selected'; ?>>
                        <?php echo $row; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-2" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info" style="width: 100%;"><?php echo get_phrase('search'); ?></button>
    </div>

</div>
<!-- fin de busquar recibo por fechas  -->
<?php echo form_close(); ?>
<br>
<!-- ----------------------------------------------------------------------------------------------------------------------------- -->
<?php
$payroll = $this->db->get_where('payroll', array('date' => $month . ',' . $year))->result_array();
if (empty($payroll)) { ?>
    <div class="alert alert-info">
        <?php echo get_phrase('no_available_data') . '!'; ?>
    </div>
<?php } else { ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>
                    <div>xx</div>
                </th>
                <th>
                    <div>ID</div>
                </th>
                <th>
                    <div><?php echo get_phrase('employee'); ?></div>
                </th>
                <!-- <th>
                    <div><?php echo get_phrase('payment_file'); ?></div>
                </th> --> <!-- agregado 2020 -->
                <th>
                    <div><?php echo get_phrase('date'); ?></div>
                </th>
                <th>
                    <div><?php echo get_phrase('status'); ?></div>
                </th>
                <th>
                    <div><?php echo get_phrase('options'); ?></div>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $this->db->order_by('payroll_id', 'desc');
            $payroll = $this->db->get_where('payroll', array('date' => $month . ',' . $year))->result_array();
            foreach ($payroll as $row) : ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['payroll_code']; ?></td>
                    <td>
                        <?php
                        $user = $this->db->get_where(
                            'user',
                            array('user_id' => $row['user_id'])
                        )->row();
                        echo $user->name; ?>
                    </td>
                   
                    <!-- COMENTADO MELISSA RESUMEN<td>
                        <?php
                        //$total_allowance    = 0;
                        //$total_deduction    = 0;
                        $allowances         = json_decode($row['allowances']);
                        $deductions         = json_decode($row['deductions']);

                        foreach ($allowances as $allowance)
                            $total_allowance += $allowance->amount;
                        foreach ($deductions as $deduction)
                            $total_deduction += $deduction->amount;

                        //$net_salary = $user->joining_salary + $total_allowance - $total_deduction;
                        $net_salary = $user->joining_salary;
                        ?>
                        <div>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: right;"><?php echo get_phrase('basic_salary'); ?></td>
                                    <td style="width: 15%; text-align: right;"> : </td>
                                    <td style="text-align: right;"><?php echo $user->joining_salary; ?></td>
                                </tr>
                                --melissa
                                     <tr>
                                    <td style="text-align: right;"><?php echo get_phrase('total_allowance'); ?></td>
                                    <td style="width: 15%; text-align: right;"> : </td>
                                    <td style="text-align: right;"><?php echo $total_allowance; ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><?php echo get_phrase('total_deduction'); ?></td>
                                    <td style="width: 15%; text-align: right;"> : </td>
                                    <td style="text-align: right;"><?php echo $total_deduction; ?></td>
                                </tr> --
                                <tr>
                                    <td colspan="3"><hr style="margin: 5px 0px;"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><?php echo get_phrase('net_salary'); ?></td>
                                    <td style="width: 15%; text-align: right;"> : </td>
                                    <td style="text-align: right;"><?php echo $net_salary; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td> -->
                    <td>
                        <?php
                        $date = explode(',', $row['date']);
                        $month_list = array(
                            'january', 'february', 'march', 'april', 'may', 'june', 'july',
                            'august', 'september', 'october', 'november', 'december'
                        );
                        for ($i = 1; $i <= 12; $i++)
                            if ($i == $date[0])
                                $m = get_phrase($month_list[$i - 1]);
                        echo $m . ', ' . $date[1];
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row['status'] == 1)
                            echo '<div class="label label-success">' . get_phrase('paid') . '</div>';
                        else
                            echo '<div class="label label-danger">' . get_phrase('unpaid') . '</div>';
                        ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                <li data-toggle="modal" data-target="#ModalPDF"><a>Mostrar archivo</a></li>

                            </ul>
                            <!--  -->
                            
                            <!--  -->
                            <div class="modal fade" id="ModalPDF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fluid modal-notify modal-info" role="document">
                                    <!--Content-->
                                    <embed id="pdfdoc" src="https://pdfobject.com/pdf/sample-3pp.pdf" width="600" height="500" alt="pdf" >

                                  <!--   <div class="modal-content">
                                        !--Header--
                                        <div class="modal-header">
                                            <p class="heading lead">archivo PDF</p>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="white-text">&times;</span>
                                            </button>
                                        </div>
                                        !--Body--
                                        <div class="modal-body">
                                           !--  <?php
                                            $image_path = base_url() . 'uploads/user_image/' . $user_code . '.jpg';
                                            if (!file_exists($image_path))
                                                $image_path = base_url() . 'uploads/user.jpg';
                                            ?> --
                                            !-- xxxx --
                                       </div>

                                        !--Footer--
                                        <div class="modal-footer justify-content-center">
                                            <a type="button" class="btn btn-info">Descargar <i class="far fa-file-pdf ml-1 text-white"></i></a>
                                            <a type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Cerrar <i class="fas fa-times ml-1"></i></a>
                                        </div>
                                    </div> -->
                                    <!--/.Content-->
                                </div>
                            </div>

                            <!--  <ul class="dropdown-menu dropdown-default pull-right" role="menu">


                                --  <iframe src="archivos.pdf" width="500" height="500"></iframe>
 --
                                <li>
                                    <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/payroll_details/' . $row['payroll_id']); ?>');">
                                        <i class="entypo-eye"></i>
                                        <?php echo get_phrase('view_payslip_details'); ?>
                                    </a>
                                </li>

                                <?php if ($row['status'] == 0) { ?>
                                    <li>
                                        <a href="<?php echo site_url('admin/payroll_list/mark_paid/' . $row['payroll_id'] . '/' . $month . '/' . $year); ?>">
                                            <i class="entypo-target"></i>
                                            <?php echo get_phrase('mark_as_paid'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul> -->
                        </div>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        // SelectBoxIt Dropdown replacement
        if ($.isFunction($.fn.selectBoxIt)) {
            $("select.selectboxit").each(function(i, el) {
                var $this = $(el),
                    opts = {
                        showFirstOption: attrDefault($this, 'first-option', true),
                        'native': attrDefault($this, 'native', false),
                        defaultText: attrDefault($this, 'text', ''),
                    };

                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }

    });
</script>

******************meliussa***********************