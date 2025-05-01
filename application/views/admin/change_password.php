<div class="page has-sidebar-right height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4> <i class="icon-table"></i> לאפס את הסיסמה</h4>
                </div>
            </div>
        </div>
    </header>
    <div class="content-wrapper animatedParent animateOnce">
        <div class="containers">
            <section class="paper-card">
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card p-2">
                            <form action="<?= site_url('admin/update_password');?>" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-3 focused">
                                        <label for="new_password" class="col-form-label">סיסמה חדשה</label>
                                        <input type="password" class="form-control" name="new_password"
                                            id="new_password" placeholder="הכנס סיסמא חדשה" required>
                                    </div>
                                    <div class="form-group col-md-12 focused">
                                        <button type="submit" class="btn btn-primary">עדכון</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </section>
        </div>
    </div>
</div>