<?php
    session_start(); // wazne, podobno... xdd

    include 'components\header.php';
    include 'components\nav.php';

    $_SESSION['logged'] = true; //temp

    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'components\panel.php';
    }
    
?>

    <div class="content">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra lobortis turpis id fringilla. Praesent lectus tellus, luctus et molestie et, consectetur ut justo. Praesent congue euismod rutrum. Maecenas non nisl euismod, fringilla diam eget, mollis purus. Integer in odio enim. Proin in lacinia augue. Duis lobortis tincidunt neque et placerat. Vestibulum vel nulla in arcu vestibulum ultricies. Fusce quis tincidunt urna, ac vehicula ex. Mauris ultricies cursus urna, nec facilisis lorem dapibus nec. Etiam ut sagittis leo, vel viverra ligula. Etiam egestas feugiat ex vitae imperdiet. Nunc vel quam vel justo molestie faucibus.</p>
        <p>Cras vulputate fermentum tincidunt. Suspendisse laoreet non ante et accumsan. Duis euismod quam nec turpis faucibus, nec faucibus diam dictum. Morbi vitae rhoncus mi, a vestibulum libero. Morbi condimentum pulvinar risus, non laoreet sapien maximus quis. Suspendisse ac convallis ligula, a elementum sem. Vestibulum ac arcu enim. Donec consectetur metus sed luctus interdum. Sed in mattis lorem. Vivamus eros orci, porttitor in gravida vitae, efficitur et nulla. Curabitur imperdiet metus vitae libero porta, sit amet ultricies orci convallis.</p>
        <p>Donec at lobortis sem. Vestibulum ut mauris eget est fringilla sollicitudin tincidunt sed dui. Etiam id elementum lorem. Donec id libero sagittis, eleifend orci a, sagittis nisl. Curabitur quis orci vitae mauris sagittis varius sollicitudin vel velit. Etiam lorem leo, egestas in justo vel, porttitor pulvinar est. Nulla sit amet commodo velit, eu fermentum est. Ut libero justo, tincidunt eget suscipit sed, efficitur eu nulla. Nullam id lectus urna.</p>
        <p>Nunc sit amet dignissim eros. Aliquam at placerat nulla, sit amet viverra metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc venenatis id nulla et finibus. Suspendisse in leo tempor, tristique dolor sodales, placerat diam. Ut et tortor in velit hendrerit ullamcorper. Integer vulputate lectus pellentesque velit dignissim, at ultrices ipsum auctor. Fusce convallis ipsum at erat vulputate laoreet vel in est. Vestibulum in nibh et dolor tempus ornare ac sodales nisi. Proin fringilla justo nec egestas ornare.</p>
    </div>
    
<?php include 'components\footer.php'; ?>