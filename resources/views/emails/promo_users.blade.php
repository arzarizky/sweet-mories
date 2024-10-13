@php
    $startDate = new DateTime($data['start_date']);
    $endDate = new DateTime($data['end_date']);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Code - Sweet Mories</title>
</head>

<body style="font-family: 'Helvetica Neue', Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div
        style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15); overflow: hidden;">

        <!-- Header -->
        <div
            style="background: linear-gradient(45deg, #6f42c1, #00aaff); padding: 50px 20px; text-align: center; color: #ffffff;">
            <img src="https://sweetmoriesstudio.com/template/assets/img/favicon/black-logo.png" alt="Sweet Mories"
                style="max-width: 120px; margin-bottom: 20px;">
            <h1 style="margin: 0; font-size: 32px; font-weight: bold; letter-spacing: 1px;">KODE PROMO {{ $data['code'] }}</h1>
            <p style="margin-top: 10px; font-size: 16px;">Terima kasih telah mempercayakan momen indahmu pada kami</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px 20px; color: #555555;">
            <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;">Halo, Mories-mates!</p>
            <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;">Terima kasih sudah mempercayai kami untuk
                mengabadikan momen indahmu. Kami akan menginformasikan bahwa kamu mendapatkan kode promo dengan
                <span>
                    <strong>potongan sebesar {{ $data['promo'] }}</strong>
                </span>
                dengan detail berikut</p>

            <div
                style="background-color: #fafafa; border-radius: 10px; padding: 20px; border: 1px solid #e0e0e0; margin-bottom: 20px;">

                <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Email</h4>
                <p style="margin-top: 5px; font-size: 16px; color: #666666;">{{ $data['email'] }}</p>

                <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Promo Berlaku Tanggal</h4>
                <p style="margin-top: 5px; font-size: 16px; color: #666666;">{{ $startDate->format('j F Y') }} Sampai
                    {{ $endDate->format('j F Y') }}</p>

                <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Promo Code</h4>
                <p style="margin-top: 5px; font-size: 16px; color: #666666;">{{ $data['code'] }}</p>

            </div>

            <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;">Abadikan momen, ciptakan cerita.<br>Di
                studio kami, kenangan takkan terlupa.
            </p>

        </div>

        <!-- Footer -->
        <div
            style="background-color: #f4f4f4; padding: 20px; text-align: center; color: #777777; border-top: 1px solid #e0e0e0;">
            <p style="font-size: 14px; color: #777777;">&copy; 2024 Sweet Mories. All rights reserved.</p>
            <p style="font-size: 14px; color: #777777;">
                <a href="https://www.instagram.com/sweetmoriesstudio?igsh=ZnhpZ2g4bHYxM3M4"
                    style="color: #C13584; text-decoration: none; margin: 0 10px;">Instagram</a> |
                <a href="https://www.facebook.com/share/898o1N7z5pfNo6Mm/?mibextid=LQQJ4d"
                    style="color: #1877F2; text-decoration: none; margin: 0 10px;">Facebook</a> |
                <a href="https://www.tiktok.com/@sweetmories.studio?_t=8pPW86NyYeA&_r=1"
                    style="color: #69C9EF; text-decoration: none; margin: 0 10px;">TikTok</a>
            </p>
            <p style="font-size: 14px; color: #777777;">
                <a href="https://sweetmoriesstudio.com" style="color: #777777; text-decoration: none;">Website</a> |
                <a href="https://api.whatsapp.com/send?phone=6285847747737" style="color: #25D366; text-dezcoration: none;">Whatsapp</a>
            </p>
        </div>
    </div>
</body>

</html>
