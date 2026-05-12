<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Quiz')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>

        *,
        *::before,
        *::after{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        :root{
            --blue:#3b82f6;
            --blue-dark:#1e3a8a;
            --blue-light:#dbeafe;

            --green:#16a34a;
            --green-light:#dcfce7;

            --red:#dc2626;
            --red-light:#fee2e2;

            --yellow:#d97706;
            --yellow-light:#fef3c7;

            --gray-50:#f8fafc;
            --gray-100:#f1f5f9;
            --gray-200:#e2e8f0;
            --gray-300:#cbd5e1;
            --gray-400:#94a3b8;
            --gray-500:#64748b;
            --gray-600:#475569;
            --gray-700:#334155;
            --gray-800:#1e293b;
            --gray-900:#0f172a;

            --radius:18px;

            --shadow:0 4px 6px rgba(0,0,0,.05);
            --shadow-md:0 10px 20px rgba(0,0,0,.08);
            --shadow-lg:0 20px 40px rgba(0,0,0,.25);
        }

        body{
            font-family:'Plus Jakarta Sans',sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #1e293b 50%,
                    #1e3a8a 100%
                );

            color:#e2e8f0;
            min-height:100vh;
        }

        /* ALERT */

        .alert{
            padding:14px 18px;
            border-radius:16px;
            font-size:14px;
            font-weight:600;
            margin-bottom:18px;
            box-shadow:var(--shadow);
        }

        .alert-success{
            background:var(--green-light);
            color:#065f46;
            border:1px solid #86efac;
        }

        .alert-error{
            background:var(--red-light);
            color:#7f1d1d;
            border:1px solid #fca5a5;
        }

        /* BUTTON */

        .btn{
            display:block;
            width:100%;
            padding:14px 18px;
            border:none;
            border-radius:16px;

            font-family:inherit;
            font-size:15px;
            font-weight:700;

            cursor:pointer;
            text-align:center;
            text-decoration:none;

            transition:.2s ease;
        }

        .btn:hover{
            transform:translateY(-2px);
            box-shadow:var(--shadow-md);
        }

        .btn:active{
            transform:scale(.98);
        }

        .btn-blue{
            background:linear-gradient(
                135deg,
                #3b82f6,
                #1e3a8a
            );
            color:white;
        }

        .btn-green{
            background:linear-gradient(135deg,#22c55e,#15803d);
            color:white;
        }

        .btn-red{
            background:linear-gradient(135deg,#ef4444,#b91c1c);
            color:white;
        }

        .btn-yellow{
            background:linear-gradient(135deg,#f59e0b,#d97706);
            color:white;
        }

        .btn-gray{
            background:var(--gray-200);
            color:var(--gray-700);
        }

        /* FORM */

        .form-group{
            margin-bottom:20px;
        }

        .form-label{
            display:block;
            font-size:14px;
            font-weight:700;
            color:#cbd5f5;
            margin-bottom:8px;
        }

        .form-control{
            width:100%;
            padding:14px 16px;

            border:1.5px solid var(--gray-300);
            border-radius:16px;

            font-family:inherit;
            font-size:15px;

            color:var(--gray-800);
            background:white;

            outline:none;
            transition:.2s;
        }

        .form-control:focus{
            border-color:var(--blue);
            box-shadow:0 0 0 4px rgba(59,130,246,.2);
        }

        .form-control.is-invalid{
            border-color:var(--red);
        }

        .invalid-feedback{
            font-size:12px;
            color:var(--red);
            margin-top:5px;
        }

        /* CARD */

        .card{
            background:rgba(255,255,255,0.96);
            border-radius:24px;
            box-shadow:var(--shadow-md);
            overflow:hidden;
        }

        .card-header{
            padding:22px 24px;
            font-size:18px;
            font-weight:800;
            color:var(--gray-800);
            border-bottom:1px solid var(--gray-100);
        }

        .card-body{
            padding:24px;
        }

        /* MODAL */

        .modal-overlay{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(15,23,42,.6);
            z-index:1000;
            align-items:center;
            justify-content:center;
            padding:20px;
            backdrop-filter:blur(6px);
        }

        .modal-overlay.active{
            display:flex;
        }

        .modal{
            background:rgba(255,255,255,0.96);
            border-radius:24px;
            width:100%;
            max-width:450px;
            box-shadow:var(--shadow-lg);
            overflow:hidden;
            animation:modalIn .2s ease;
        }

        @keyframes modalIn{
            from{
                transform:translateY(20px) scale(.96);
                opacity:0;
            }
            to{
                transform:translateY(0) scale(1);
                opacity:1;
            }
        }

        .modal-header{
            padding:22px 24px;
            font-size:20px;
            font-weight:800;
            border-bottom:1px solid var(--gray-100);
            color:var(--gray-800);
        }

        .modal-body{
            padding:24px;
        }

        /* TABLE */

        .table-wrap{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            font-size:14px;
        }

        th{
            text-align:left;
            padding:16px;
            font-size:13px;
            font-weight:700;
            color:var(--gray-600);
            background:var(--gray-50);
            border-bottom:2px solid var(--gray-100);
        }

        td{
            padding:16px;
            border-bottom:1px solid var(--gray-100);
            color:var(--gray-700);
        }

        tr:hover{
            background:#f1f5f9;
        }

        tr:last-child td{
            border-bottom:none;
        }

        /* BADGE */

        .badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:6px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
        }

        .badge-green{
            background:var(--green-light);
            color:#065f46;
        }

        .badge-yellow{
            background:var(--yellow-light);
            color:#78350f;
        }

        .badge-gray{
            background:var(--gray-200);
            color:var(--gray-600);
        }

        @media(max-width:640px){
            .card-header{
                font-size:16px;
                padding:18px;
            }

            .card-body{
                padding:18px;
            }

            .modal{
                border-radius:20px;
            }

            .modal-header,
            .modal-body{
                padding:20px;
            }

            th,
            td{
                padding:12px;
                font-size:13px;
            }
        }

        @yield('extra-styles')

    </style>

</head>

<body>

    @yield('content')

</body>
</html>