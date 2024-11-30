<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!-- Sidebar Menu -->
        <div id="sidebar-menu">
            <ul>
                <!-- Menu Title -->
                <li class="menu-title">Menu</li>

                <!-- Dashboard Link -->
                @if(auth()->user()->role !== 'voter')
                <li>
                    <a href="dashboard" class="waves-effect"><i class="mdi mdi-home"></i><span> Dashboard</span></a>
                </li>
                @endif
                <li>
                    <a href="polls" class="waves-effect"><i class="mdi mdi-home"></i><span> Polls</span></a>
                </li>
                <!-- Create Poll Link (Visible only if user is not 'voter') -->
                @if(auth()->user()->role !== 'voter')
                    <li class="form contact contact-number">
                        <a href="/add_poll" class="waves-effect">
                            <i class="ion ion-md-call"></i> <!-- Contact icon -->
                            <span>Create Poll</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- End Sidebar Menu -->

        <div class="clearfix"></div>
    </div> <!-- End sidebar-inner -->
</div> <!-- End Left Sidebar -->