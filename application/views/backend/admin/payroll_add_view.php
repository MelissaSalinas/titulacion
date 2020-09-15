<!-- ini -->
<?php
require_once 'conexion.php';
if (isset($_POST['btnsave'])) {
    $_SESSION['data'] = 'locoo';
    $certFile = $_FILES['archivo']['name'];
    $tmpcert_dir = $_FILES['archivo']['tmp_name'];
    $certSize = $_FILES['archivo']['size'];

    $id_departamento = $_POST['department_id'];
    $id_user = $_POST['employee_id'];
    $mes = $_POST['month'];
    $anio = $_POST['year'];
    $dateanio = $mes."-".$anio;

    $count = 1;
    $uploadcertificado_dir = 'Archivos/pdf/';

    $certExt = strtolower(pathinfo($certFile, PATHINFO_EXTENSION));
    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf'); // valid extensions

    // rename uploading image
    $certificadopic = rand(1000, 1000000) . "." . $certExt;


    if (in_array($certExt, $valid_extensions)) {
        // Check file size '5MB'
        if ($certSize < 5000000) {
            move_uploaded_file($tmpcert_dir, $uploadcertificado_dir . $certificadopic);
        } else {
            $errMSG = "Sorry, your file is too large.";
        }
    } else {

        $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $resul = mysqli_query($conn, "INSERT INTO archivos (nombre,user_id,department_id, datefecha) VALUES ('".$certificadopic ."','".$id_user."','".$id_departamento."','".$dateanio."')");
        ?>
        <div class="alert alert-success form-group">
            <strong>archivo subido correctamente</strong>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning">
            <strong>solo ......</strong>
        </div>
<?php
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <title> Upload </title>
</head>
<!-- fin -->
<!-- inicio de cabecera  -->
<form method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('department'); ?></label>
            
            <select name="department_id" class="form-control" onchange="get_employees(this.value);" required>
                <option value=""><?php echo get_phrase('select_a_department'); ?></option>
                <?php
                $departments = $this->db->get('department')->result_array();
                foreach ($departments as $row) : ?>
                    <option value="<?php echo $row['department_id']; ?>" <?php if ($row['department_id'] == $department_id) echo 'selected'; ?>>
                        <?php echo $row['name'] . ' ' . get_phrase('department'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('employee'); ?></label>
            <select name="employee_id" class="form-control" id="employee_holder" required>
                <?php
                $employees = $this->db->get_where(
                    'user',
                    array('type' => 2, 'department_id' => $department_id)
                )->result_array();
                foreach ($employees as $row) : ?>
                    <option value="<?php echo $row['user_id']; ?>" <?php if ($row['user_id'] == $employee_id) echo 'selected'; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('month'); ?></label>
            <select name="month" class="form-control" required>
                <option value=""><?php echo get_phrase('select_a_month'); ?></option>
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

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('year'); ?></label>
            <select name="year" class="form-control" required>
                <option value=""><?php echo get_phrase('select_a_year'); ?></option>
                <?php
                for ($i = 2016; $i <= 2026; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php if ($i == $year) echo 'selected'; ?>>
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-2" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info" style="width: 100%;">
            <?php echo get_phrase('submit'); ?></button>
    </div>

</div>
<!-- fin de cabecera -->
<hr />
<!-- inicio de subir archivo -->
<div class="row">
<div class="form-group">                   
                    <label for="field-2" class="col-sm-2 "><?php echo get_phrase('payment_file'); ?></label>                    
                    <div class="col-md-8">        
                    <div>
                        <input type="file" name="archivo" id="archivo" class="form-control" role="form" required />
                    </div>
                    </div>
                    <div class="col-md-2">
    <input type="submit" name="btnsave"class="btn btn-blue btn-icon icon-left" value="Subir">
    </div>
                </div>
    
</div>

<!-- fin de subir archivo -->
 </form> 

<?php echo form_open(
    site_url('admin/create_payroll'),
    array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data')
); ?>

<div class="row">
   <!--  <div class="col-md-offset-1 col-md-10"> -->
         <!-- <div class="panel panel-primary" data-collapsed="0"> -->
            <div class="panel-body "> 
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-2"><?php echo get_phrase('status'); ?></label>
                    <div class="col-sm-8">
                        <select name="status" class="form-control ">
                            <option value="1"><?php echo get_phrase('paid'); ?></option>
                            <option value="0"><?php echo get_phrase('unpaid'); ?></option>
                        </select>
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-success"><?php echo get_phrase('create_payslip'); ?></button>
                    </div>
                </div>
             </div>
        <!-- </div> --> 
   <!--  </div> -->

</div>

<input type="hidden" name="user_id" value="<?php echo $employee_id; ?>" />
<input type="hidden" name="month" value="<?php echo $month; ?>" />
<input type="hidden" name="year" value="<?php echo $year; ?>" />

<?php echo form_close(); ?>

<script type="text/javascript">
    var allowance_count = 1;
    var deduction_count = 1;
    //var total_allowance = 0;
    //var total_deduction = 0;
    var deleted_allowances = [];
    var deleted_deductions = [];

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

    function get_employees(department_id) {
        if (department_id != '')
            $.ajax({
                url: '<?php echo site_url('admin/get_employees/'); ?>' + department_id,
                success: function(response) {
                    jQuery('#employee_holder').html(response);
                }
            });
        else
            jQuery('#employee_holder').html('<option value=""><?php echo get_phrase("select_a_department_first"); ?></option>');
    }

    $('#allowance_input').hide();

    // CREATING BLANK ALLOWANCE INPUT
    var blank_allowance = '';
    $(document).ready(function() {
        blank_allowance = $('#allowance_input').html();
    });

    function add_allowance() {
        allowance_count++;
        $("#allowance").append(blank_allowance);
        $('#allowance_amount').attr('id', 'allowance_amount_' + allowance_count);
        $('#allowance_amount_delete').attr('id', 'allowance_amount_delete_' + allowance_count);
        $('#allowance_amount_delete_' + allowance_count).attr('onclick', 'deleteAllowanceParentElement(this, ' + allowance_count + ')');
    }

    // REMOVING ALLOWANCE INPUT
    function deleteAllowanceParentElement(n, allowance_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_allowances.push(allowance_count);
    }
    $('#deduction_input').hide();

    // CREATING BLANK DEDUCTION INPUT
    var blank_deduction = '';
    $(document).ready(function() {
        blank_deduction = $('#deduction_input').html();
    });

    function add_deduction() {
        deduction_count++;
        $("#deduction").append(blank_deduction);
        $('#deduction_amount').attr('id', 'deduction_amount_' + deduction_count);
        $('#deduction_amount_delete').attr('id', 'deduction_amount_delete_' + deduction_count);
        $('#deduction_amount_delete_' + deduction_count).attr('onclick', 'deleteDeductionParentElement(this, ' + deduction_count + ')');
    }

    // REMOVING DEDUCTION INPUT
    function deleteDeductionParentElement(n, deduction_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_deductions.push(deduction_count);
    }

    function calculate_total_deduction() {
        var amount;
        for (i = 1; i <= deduction_count; i++) {
            if (jQuery.inArray(i, deleted_deductions) == -1) {
                amount = $('#deduction_amount_' + i).val();

                if (amount != '') {
                    amount = parseInt(amount);
                    total_deduction = amount + total_deduction;
                    $('#total_deduction').attr('value', total_deduction);
                }
            }
        }
        // net_salary = parseInt($('#basic').val()) + parseInt($('#total_allowance').val()) - parseInt($('#total_deduction').val());
        net_salary = parseInt($('#basic').val());

        $('#net_salary').attr('value', net_salary);
        total_deduction = 0;
    }
</script>