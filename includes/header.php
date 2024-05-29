<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<link href="css/header_new.css" rel="stylesheet">

<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="background-color:#40513b;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="dashboard.php"><span>Daily Expense Tracker</span></a>
            <div id="menu">
                <nav>
                    <ul>
                        <li><a href="dashboard.php">Home</a></li>
                         <!-- <li><a href="#">Account</a></li> -->
                        <!--<li><a href="/html/transaction.html">Transaction</a></li>
                        <li><a href="report.php">Report</a></li>
                        <li><a href="/html/transaction.html">Contact</a></li> -->
                        <li><a href="help.html">Help</a></li>
                    </ul>
                </nav>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</nav>