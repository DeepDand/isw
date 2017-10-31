SORT: <?php echo anchor('discussions/index/sort/age/' . (($dir == 'ASC') ? 'DESC' : 'ASC'),'Newest '
            . (($dir == 'ASC') ? 'DESC' : 'ASC'));?>

<div class="container theme-showcase" role="main">
  <table class="table table-hover">
  <thead>
    <tr>
      <th><?php echo $this->lang->line('discussions_title') ; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($query->result() as $result) : ?>
      <tr>
        <td>
          <?php //echo anchor('comments/index/'.$result->ds_id,$result->ds_title) . ' '
                //. $this->lang->line('comments_created_by') . $result->usr_name;
                echo $this->input->post($result->ds_id,$result->ds_title);
                echo anchor('c=comments&m=index&ds_id='.$result->ds_id,$result->ds_title) . ' '
                      .$this->lang->line('comments_created_by').$result->usr_name;

                      //echo anchor('c=comments&m=index&ds_id='.$result->ds_id.'&ds_title'.$result->ds_title) . ' '
                      //      .$this->lang->line('comments_created_by').$result->usr_name;

                ?>

          <?php echo anchor(base_url().'discussions/flag/'.$result->ds_id,
          $this->lang->line('discussion_flag')) ; ?>
          <br />
          <?php echo $result->ds_body ; ?>
        </td>
      </tr>
    <?php endforeach ; ?>

  </tbody>
</table>
</div>
