<?php
if ($_SERVER['REQUEST_URI'] == '/index.php') {
    header('Location: /');
    exit();
}
$title = "Home page";

ob_start();
?>

    <h1>Home page</h1>
<div>
    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor eveniet libero numquam quos sapiente soluta!
        Adipisci aliquid aspernatur, dignissimos dolor doloremque ex fugiat fugit hic in itaque libero possimus quam?
    </div>
    <div>Alias dicta dolorem, est harum inventore quaerat tempora. Dignissimos facere hic id ipsa laboriosam libero nemo
        neque sint, sit, soluta tempora tenetur totam, veritatis. Eveniet pariatur quibusdam quos voluptatem voluptates!
    </div>
    <div>Accusamus ad aspernatur beatae blanditiis consectetur corporis culpa cum ducimus esse ex laudantium libero modi
        nemo neque nesciunt obcaecati pariatur quibusdam quos recusandae reiciendis rem repellendus, sed similique
        veniam vitae!
    </div>
    <div>Ipsa ipsam libero pariatur ratione saepe sapiente! Est et iste sed velit. Asperiores, aut dolores eaque et iste
        iusto maxime molestias mollitia nemo nihil quia quo rerum tenetur ut vitae.
    </div>
    <div>Aliquid atque autem, blanditiis consequatur cumque dolore earum enim, eos error hic illo iusto minus modi
        numquam quam quas quibusdam rerum sapiente sint unde. Facilis, iure, repudiandae. Assumenda perspiciatis,
        possimus?
    </div>
    <div>A, alias architecto aut distinctio doloremque doloribus ea exercitationem explicabo impedit incidunt iure iusto
        magni minima obcaecati praesentium provident quae quisquam reprehenderit sequi sint soluta ut voluptatem?
        Exercitationem, modi suscipit?
    </div>
    <div>Ad commodi cum doloribus eaque incidunt minus molestiae neque praesentium sequi voluptates? Adipisci alias
        fugit, iure minima molestiae nostrum sunt tempore totam. Enim eum neque nulla sit. Iure, laboriosam omnis.
    </div>
    <div>A, accusamus amet at consequatur debitis distinctio est eum ipsa itaque labore laboriosam, laudantium minima
        nam nobis non odio repellat saepe sequi tempore vel? Exercitationem illo illum iusto repellat repellendus?
    </div>
    <div>Aliquid animi aperiam blanditiis eveniet exercitationem, magni maiores molestiae nemo nihil non officiis omnis
        sequi sint! Aliquam autem commodi fuga ipsum nisi placeat tempore! Architecto dolorem facilis iure porro vel.
    </div>
    <div>Accusamus aperiam deserunt dignissimos, eius eligendi enim, eos laborum omnis quia tempora temporibus ut velit
        voluptatum. A deleniti deserunt dolores dolorum ducimus, excepturi inventore nisi quod repellat sit vero vitae?
    </div></div>
<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>