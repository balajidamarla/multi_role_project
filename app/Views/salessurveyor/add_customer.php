<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Add Customer</h3>
    <form method="post" action="<?= base_url('admin/store_customer') ?>">
        <?= csrf_field() ?>

        <!-- Company Name -->
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <!-- First Name and Last Name -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
        </div>

        <!-- Email and Phone -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
        </div>

        <!-- Address1 and Address2 -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Address 1</label>
                <input type="text" name="address1" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>Address 2</label>
                <input type="text" name="address2" class="form-control">
            </div>
        </div>

        <!-- Zipcode and City/State -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Zipcode</label>
                <input type="text" name="zipcode" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>City State</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success mt-2">Add Customer</button>
    </form>
</div>



<?= $this->endSection() ?>