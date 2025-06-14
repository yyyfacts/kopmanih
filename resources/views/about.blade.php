<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang Pembuat - Koperasi Mahasiswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f8f9fa;
      font-family: sans-serif;
    }
    .card {
      border-radius: 12px;
    }
    .developer-avatar {
      width: 40px;
      height: 40px;
      background: #e0e0e0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .about-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .about-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
    }

    .about-hero-content {
        padding: 3rem 2rem;
        text-align: center;
    }

    .about-hero-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 1rem 0;
    }

    .about-hero-content p {
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
    }

    .about-hero-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .team-member {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: #F9FAFB;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .team-member:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    }

    .member-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        font-weight: 600;
    }

    .member-info {
        flex: 1;
    }

    .member-info h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.25rem;
    }

    .member-nim {
        color: var(--secondary);
        font-size: 0.875rem;
        margin: 0 0 0.5rem;
    }

    .member-role {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .project-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
    }

    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .info-content h4 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.25rem;
    }

    .info-content p {
        color: var(--secondary);
        margin: 0;
        font-size: 0.875rem;
    }

    .about-footer {
        text-align: center;
        padding: 2rem 0;
        color: var(--secondary);
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .team-grid {
            grid-template-columns: 1fr;
        }

        .project-info {
            grid-template-columns: 1fr;
        }
    }
  </style>
</head>
<body>

  <nav class="navbar bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
      <h5 class="m-0 text-success fw-bold">Tentang Pembuat</h5>
      <dv></div> <!-- Spacer -->
    </div>
  </nav>

  <div class="container py-4">
    <div class="card shadow-sm mb-4">
      <div class="card-body text-center">
        <div class="text-primary mb-2" style="font-size: 50px;">
          <i class="bi bi-people-fill"></i>
        </div>
        <h5 class="fw-bold mb-0">Tim Pengembang</h5>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="fw-bold">Anggota Tim:</h6>
        <hr>
        @php
          $members = [
            ['name' => 'Rafly Romeo', 'nim' => '2211102265'],
            ['name' => 'Rizky Cristian', 'nim' => '21102248'],
            ['name' => 'Rocky Justice Sibuea', 'nim' => '2211102260'],
            ['name' => 'Muhammad Ardhito', 'nim' => '2211102244'],
            ['name' => 'Dwyan Ramadhani Saputra', 'nim' => '2211102227'],
            ['name' => 'Zain Aufa Rahman', 'nim' => '2211102231'],
          ];
        @endphp

        @foreach($members as $member)
          <div class="d-flex align-items-center mb-3">
            <div class="developer-avatar me-3">
              <i class="bi bi-person-fill"></i>
            </div>
            <div>
              <div class="fw-medium">{{ $member['name'] }}</div>
              <div class="text-muted">NIM: {{ $member['nim'] }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <footer class="position-fixed bottom-0 end-0 p-2 text-muted small">
    &copy; Syechan
  </footer>
</body>
</body>
</html>
