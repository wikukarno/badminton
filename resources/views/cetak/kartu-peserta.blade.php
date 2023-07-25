<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu Peserta</title>
    <style>
        .table {
            width: 60%;
            margin: 35% auto;
            align-self: auto;
            text-align: center;
            padding: 30px;
            border: black 2px solid;
        }
        .photo-peserta {
            width: 100px;
            height: 110px;
        }
        .atlet{
            margin-top: -10px !important;
        }

        hr {
            margin-top: 120px;
            border: 1px solid black;
            width: 170px;
        }

        .brand-img {
            width: 500px;
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <section class="section-content-card">
        <div class="profile">
            <table class="table">
                <div class="profile-img">
                    <img src="{{ $pic }}" class="photo-peserta" alt="Logo">
                </div>
                <div class="profile-name">
                    <h1>{{ $data->user->name }}</h1>
                    <p class="atlet"> ~ Atlet Badminton, 
                        {{ \Carbon\Carbon::parse($data->user->tanggal_lahir)->diff(\Carbon\Carbon::now())->format('%y') }} ~
                    </p>
                </div>


                <hr />
                <p>
                    Junjung Tinggi Sportivitas, Hargai Perbedaan, <br /> dan Jauhi Narkoba.
                </p>

                
            </table>
        </div>
    </section>
</body>
</html>