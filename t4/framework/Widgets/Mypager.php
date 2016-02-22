<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.02.16
 * Time: 7:27
 */

namespace T4\Widgets;


class MyPager
    extends Pager
{
    public function render()
    {
        $pagesCount = ceil($this->options->total / $this->options->size);
        if (!$pagesCount)
            return;

        $displayed = [
            1, 2, 3,
            $this->options->active - 1, $this->options->active, $this->options->active + 1,
            $pagesCount - 2, $pagesCount - 1, $pagesCount
        ];
        $displayed = array_unique(array_filter($displayed, function ($d) use ($pagesCount) {
            return $d >= 1 && $d <= $pagesCount;
        }));

        if (($this->options->active - 1) - 3 == 2) {
            $displayed[] = 4;
        }
        if (($pagesCount - 2) - ($this->options->active + 1) == 2) {
            $displayed[] = $pagesCount - 3;
        }
        sort($displayed);
        ?>
        <ul class="pagination">
            <li<?php echo($this->options->active == 1 ? ' class="disabled"' : ''); ?>><a
                    href="<?php printf($this->options->url, 1);echo '&topic='.$this->options->myPage ?>">&laquo;</a></li>
            <?php
            $prev = 1;
            foreach ($displayed as $page) {
                if ($page - $prev > 1) {
                    ?>
                    <li class="disabled"><a href="#">...</a></li><?php
                }
                ?>
                <li<?php echo($this->options->active == $page ? ' class="active"' : ''); ?>>
                    <a href="<?php printf($this->options->url, $page);echo '&topic='.$this->options->myPage?>"><?php echo $page?></a>
                </li>
                <?php
                $prev = $page;
            }
            ?>
            <li<?php echo($this->options->active == $pagesCount ? ' class="disabled"' : ''); ?>><a
                    href="<?php printf($this->options->url, $page);echo '&topic='.$this->options->myPage?>">&raquo;</a>
            </li>
        </ul>
        <?php
    }
}