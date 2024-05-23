<div class="flex width-50 flex-s-btn">
    <a href="sale.php" class="saleBtn text-w anchor">[sale]</a>
    <div class="" style="display: none;">
        <span id="notfyBtn" class="theme-text"> <span><i class="fa fa-bell" aria-hidden="true"></i><i class="fa fa-circle alert-circle" aria-hidden="true"></i> </span> </span>
        <div id="notifyContainer">
            <!-- Dropdown content goes here -->
            <a class="theme-text" href="#">2 Items needs re-order</a>
            <a class="theme-text" href="#">Notification 2</a>
            <a class="theme-text" href="#">Notification 3</a>
        </div>

    </div>
    <div class="">
        <h4 id="profileBtn" class="theme-text pointer"><i class="fas fa-user    "></i> <?= $_SESSION['welix_loged_in']['username'] ?></h4>
        <div id="profileDropDown">
            <!-- Dropdown content goes here -->
            <a class="theme-text-c w-500" href="setting.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Your Profile</a>
            <a class="theme-text-c w-500" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Log Out</a>
        </div>
    </div>
</div>