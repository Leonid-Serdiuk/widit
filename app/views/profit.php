<div class="page-top-panel">
    <h1>Profit</h1>
</div>
<?php $this->view->include('includes/alert'); ?>
<div class="row block-margin-bottom">
    <div class="col-md-12">
        <button class="btn btn-default" data-toggle="collapse" data-target="#add_profit_form" aria-expanded="false" aria-controls="add_profit_form">Add Profit </button>
        <div class="collapse" id="add_profit_form">
            <div class="well">
               <form method="post" action="<?php System::site_url('profit/add_profit') ?>">
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="title">Title</label>
                               <input type="text" id="title" class="form-control" name="title">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="tag">Tag</label>
                               <select id="tag" class="form-control" name="tag">
                                   <option>Deposit</option>
                                   <option>Gift</option>
                                   <option>Monthly Payment</option>
                               </select>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="amount">Amount</label>
                               <input type="number" id="amount" min="0.01" step="0.01" class="form-control" name="amount">
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="comment">Commnet</label>
                               <textarea class="form-control" name="comment" id="comment"></textarea>
                           </div>
                       </div>
                       <div class="col-md-12 text-center">
                           <input type="submit" value="Submit" class="btn btn-success">
                       </div>
                   </div>
               </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form method="post" action="<?php system::site_url('profit/change_period'); ?>" class="form-inline show-inline-block">
                <h3 class="panel-title show-inline-block">Profit per
                <select name="period" onchange="this.form.submit()" class="form-control">
                    <option value="month" <?php echo $period == 'month' ? 'selected="selected"' : ''; ?>>Month</option>
                    <option value="week" <?php echo $period == 'week' ? 'selected="selected"' : ''; ?>>Week</option>
                    <option value="day" <?php echo $period == 'day' ? 'selected="selected"' : ''; ?>>Day</option>
                </select>
                <?php
                    $ends = array(1 => 'st', 2 => 'nd', 3 => 'rd');

                    if($period_number == $current_period_number)
                    {
                        echo ' Current ' . $period;
                    }
                    else if ($period == 'month')
                    {
                        $dateObj = DateTime::createFromFormat('n', $period_number);
                        echo ($period_number == 2) ? 'February' : $dateObj->format('F');
                    }
                    else if ($period == 'week')
                    {

                        $week_of_month = ($period_number - $min_week_num) + 1;
                        echo (isset($ends[$week_of_month])) ? $week_of_month . $ends[$week_of_month] : $week_of_month . 'th';
                        echo ' week of the month';
                    }
                    else if ($period == 'day')
                    {
                        $dateObj = DateTime::createFromFormat('j', $period_number);
                        echo $dateObj->format('F') . ' ';
                        echo (isset($ends[$period_number])) ? $period_number . $ends[$period_number] : $period_number . 'th';
                    }
                ?>
                </h3>
                </form>
                <button type="button" class="btn btn-info hidden-xs hidden-sm pull-right">Print</button>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php if (!$profits): ?>
                    <h4>There is no profit yet.</h4>
                    <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Tag</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profits as $index => $profit): ?>
                            <tr>
                                <td><?php echo $profit->created_at; ?></td>
                                <td><?php echo $profit->title; ?></td>
                                <td><?php echo $profit->amount; ?></td>
                                <td><?php echo $profit->tag_id; ?></td>
                                <td><?php echo $profit->comment; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
            <div class="panel-footer">
                <ul class="pager">
                    <?php $prev_period = $period_number - 1; if(($period != 'week' && $prev_period > 0) || ($period == 'week' && $prev_period >= $min_week_num)): ?>
                    <li class="previous"><a href="<?php System::site_url('profit/' . $period . '/' . $prev_period); ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php $next_period = $period_number + 1; if($next_period <= $current_period_number): ?>
                    <li class="next"><a href="<?php $url_part = ($next_period == $current_period_number) ? 'profit' : 'profit/' . $period . '/' . $next_period; System::site_url($url_part); ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>


    </div>
</div>

