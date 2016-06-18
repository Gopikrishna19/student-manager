<?php
function homeMenu() {
    ?>
<li data-count="1" class="menu" data-page="login/page" data-title="Login">Log In</li>
<li data-count="2" class="menu" data-page="../common/notes" data-title="Notifications">Notifications</li>
<li data-count="3" class="menu" data-page=""><div id="home-btn" title="Go to<br>SACET Home Page"><a href="http://sacet.edu.in"></div></a></li>
    <?php
}
function adminMenu() {
    ?>
<li data-count="1" class="menu" data-page="user/page" data-title="Manage Users and Moderators">Users</li>
<li data-count="2" class="menu" data-page="dept/page" data-title="Manage Departmets">Departments</li>
<li data-count="3" class="menu" data-page="note/page" data-title="Set Notifications">Notifications</li>
<li data-count="4" class="menu" data-page="userterms"  data-title="Types of Users and Their Access Levels">Users & Permissions</li>
<li data-count="5" class="menu" data-page=""><a href="../mod">
    <div style="display: inline; font-size: 14px" title="Switch to<br>Moderation">Moderation</div></a>
</li>
<li data-count="6" class="menu" data-page=""><a href="../home"><div id="lout-btn" title="Log Out of<br>Your Account"></div></a></li>
<li data-count="7" class="menu" data-page="../common/sets/page" data-title="Settings">
    <div id="sets-btn" title="Adjust Your<br>Account Settings"></div>
</li>
    <?php
}
function userMenu() {
    ?>
<li data-count="1" class="menu" data-page="../common/notes" data-title="Notifications">Notifications</li>
<li data-count="2" class="menu" data-page="attd/page" data-title="Attendance">Attendance</li>
<li data-count="3" class="menu" data-page="mark/page" data-title="Marks">Marks</li>
<li data-count="4" class="menu" data-page=""><a href="../home"><div id="lout-btn" title="Log Out of<br>Your Account"></div></a></li>
<li data-count="5" class="menu" data-page="../common/sets/page" data-title="Settings">
    <div id="sets-btn" title="Adjust Your<br>Account Settings"></div>
</li>
    <?php 
}
function modMenu() {
    ?>
<li data-count="1" class="menu" data-page="subs/page" data-title="Manage Subjects">Subjects</li>
<li data-count="2" class="menu" data-page="attd/page" data-title="Manage Attendance">Attendance Entry</li>
<li data-count="3" class="menu" data-page="attr/page" data-title="Attendance Report">Attendance Report</li>
<li data-count="4" class="menu" data-page="mark/page" data-title="Manage Marks">Marks Entry</li>
<li data-count="5" class="menu" data-page="marr/page" data-title="Marks Report">Marks Report</li>
<li data-count="6" class="menu" data-page=""><a href="../home"><div id="lout-btn" title="Log Out of<br>Your Account"></div></a></li>
<li data-count="7" class="menu" data-page="../common/sets/page" data-title="Settings">
    <div id="sets-btn" title="Adjust Your<br>Account Settings"></div>
</li>
    <?php   
}
?>