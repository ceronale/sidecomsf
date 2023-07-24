<?php

function showSweetAlert($title, $text, $icon, $confirmButtonText = 'Aceptar', $redirectURL = null)
{
    $currentURL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $currentURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $basePath = dirname($currentURL);

    $sweetAlertCode = '
        <script>
            Swal.fire({
                title: "' . $title . '",
                text: "' . $text . '",
                icon: "' . $icon . '",
                confirmButtonText: "' . $confirmButtonText . '",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
        ';

    if ($redirectURL) {
        $redirectURL = $basePath . $redirectURL;
        $sweetAlertCode .= 'window.location.href = "' . $redirectURL . '";';
    }

    $sweetAlertCode .= '
                }
            });
        </script>
    ';

    return $sweetAlertCode;
}
