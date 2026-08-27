@include('partials.adminnav')
<link rel="stylesheet" href="/css/dashboard.css">
<div class="wrap">

  <div class="hero">
    <div class="hero-left">
      <h1>Good morning, {{ auth()->guard('admin')->user()->firstname }}! 👋</h1>
      <div class="rule"></div>
      <p>Manage research papers, archives and borrowing from one place.</p>
    </div>
    <div class="hero-mid">
      <div class="contrail"></div>
      <svg class="plane" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 46 L120 40 L170 18 L182 20 L150 44 L196 46 L196 52 L150 52 L182 66 L170 68 L118 48 L34 52 L20 60 L8 58 L16 48 Z" fill="#ffffff" opacity="0.95"/>
      </svg>
    </div>
    <div class="hero-quote">"Preserving knowledge today, inspiring tomorrow's aviation leaders."</div>
  </div>

  <div class="stats">
    <div class="card stat">
      <div class="stat-top">
        <div class="stat-icon" style="background:#E9F0FE;color:var(--blue-700);"><svg class="icon" viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 013 3v11a2 2 0 00-2-2H4z"/><path d="M20 5h-7a3 3 0 00-3 3v11a2 2 0 012-2h8z"/></svg></div>
        <div><div class="stat-label">Research papers</div><div class="stat-value"> {{ $totalUpload }}</div></div>
      </div>
      <div class="stat-foot up"></div>
    </div>
    <div class="card stat">
      <div class="stat-top">
        <div class="stat-icon" style="background:var(--amber-bg);color:var(--amber);"><svg class="icon" viewBox="0 0 24 24"><path d="M6 3h12M6 21h12M7 3c0 6 5 7 5 9s-5 3-5 9M17 3c0 6-5 7-5 9s5 3 5 9"/></svg></div>
        <div><div class="stat-label">Pending reviews</div><div class="stat-value"> {{ $totalPending }}</div></div>
      </div>
      <div class="stat-foot neutral"></div>
    </div>
    <div class="card stat">
      <div class="stat-top">
        <div class="stat-icon" style="background:var(--green-bg);color:var(--green);"><svg class="icon" viewBox="0 0 24 24"><path d="M4 19.5V6a2 2 0 012-2h13v15H6.5a2.5 2.5 0 000 5H19"/></svg></div>
        <div><div class="stat-label">Borrowed books</div><div class="stat-value"> {{ $totalBorrowed }}</div></div>
      </div>
      <div class="stat-foot down"></div>
    </div>
    <div class="card stat link" onclick="printArchive()">
      <div class="stat-top">
        <div class="stat-icon" style="background:var(--purple-bg);color:var(--purple);"><svg class="icon" viewBox="0 0 24 24"><path d="M6 9V3h12v6M6 18h12v3H6z"/><rect x="6" y="9" width="12" height="9"/></svg></div>
        <div><div class="stat-label">Print</div><div class="stat-value">Thesis list</div></div>
      </div>
      <div class="stat-foot">Go to print list →</div>
    </div>
  </div>
 <div class="mt-2">
      <div class="charts">
        <div class="card chart-card c-green">
          <h3>Research by year</h3>
          <div class="chart-box"><canvas id="yearChart"></canvas></div>
        </div>
        <div class="card chart-card c-purple">
            <h3>Department distribution</h3>
            <div class="chart-row">
                <div class="chart-box"><canvas id="deptChart"></canvas></div>
                <div class="legend">
                <div class="legend-row"><span><span class="dot" style="background:#2E6FE0;"></span>BSAMT</span><span>{{ $deptDistribution['BSAMT'] ?? 0 }}%</span></div>
                <div class="legend-row"><span><span class="dot" style="background:#1AA05B;"></span>BSEAT</span><span>{{ $deptDistribution['BSAET'] ?? 0 }}%</span></div>
                <div class="legend-row"><span><span class="dot" style="background:#9AA4B2;"></span>Others</span><span>{{ $deptDistribution['Others'] ?? 0 }}%</span></div>
                </div>
            </div>
            </div>
      </div>
  </div>
  <div class="layout">
    <div class="left-col">
      <div class="card">
        <div class="panel-head">
          <h2>Recent uploads</h2>
          <a href="/admin/dashboard/archive/pending" class="btn-mini">View all</a>
        </div>
        <table>
          <thead>
            <tr><th>Book number</th><th>Title</th><th>Dept.</th><th>Instructor</th><th>Year</th></tr>
          </thead>
          <tbody>
            @forelse($recentUploads as $upload)
                <tr>
                <td class="bnum">{{ $upload->book_number }}</td>
                <td class="row-title">   {{ $upload->title }}&hellip;</td>
                <td><div class="dept-cell">{{ $upload->department }}</div></td>
                <td class="row-title"> {{ $upload->adviser }}</td>
                <td class="date"> {{ $upload->year }}</td>
                </tr>
            @empty
                <tr>
                    <td class="row-title">No recent uploads.</td>
                </tr>
             @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="right-col">
      <div class="card">
        <div class="panel-head mt-2 "><h2>Quick actions</h2></div>
        <div class="actionlist">
          <a class="act a-blue" href="/admin/dashboard/thesis/upload">
            <div class="glyph"><svg class="icon" viewBox="0 0 24 24" style="stroke:#fff;"><path d="M12 19V5M5 12l7-7 7 7"/></svg></div>
            <div><div class="t">Upload research</div><div class="s">Add a new research paper</div></div>
            <span class="chev">›</span>
          </a>
          <a class="act a-green" href="/admin/dashboard/archive">
            <div class="glyph"><svg class="icon" viewBox="0 0 24 24" style="stroke:#fff;"><path d="M3 7h6l2 2h10v10H3z"/></svg></div>
            <div><div class="t">Browse archive</div><div class="s">View archived research papers</div></div>
            <span class="chev">›</span>
          </a>
          <a class="act a-amber" href="/admin/dashboard/borrow">
            <div class="glyph"><svg class="icon" viewBox="0 0 24 24" style="stroke:#fff;"><path d="M4 19.5V6a2 2 0 012-2h13v15H6.5a2.5 2.5 0 000 5H19"/></svg></div>
            <div><div class="t">Borrow books</div><div class="s">Manage borrow requests</div></div>
            <span class="chev">›</span>
          </a>
          <a class="act a-purple" href="/admin/dashboard/search">
            <div class="glyph"><svg class="icon" viewBox="0 0 24 24" style="stroke:#fff;"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg></div>
            <div><div class="t">Search research</div><div class="s">Search archived research</div></div>
            <span class="chev">›</span>
          </a>
            <a class="act a-slate" href="/admin/dashboard/instructor">
            <div class="glyph"><svg class="icon" viewBox="0 0 24 24" style="stroke:#fff;"><circle cx="12" cy="8" r="3"/><path d="M5 20c0-4 3-6 7-6s7 2 7 6"/></svg></div>
            <div><div class="t">Instructor directory</div><div class="s">Search instructors</div></div>
            <span class="chev">›</span>
            </a>
            <a class="act a-teal" href="/admin/dashboard/calendar">
            <div class="glyph">
                <svg class="icon" viewBox="0 0 24 24" fill="none" style="stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"> <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                    <line x1="8" y1="2" x2="8" y2="6"></line> <line x1="16" y1="2" x2="16" y2="6"></line> <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div><div class="t">Calendar</div><div class="s">View all Schedule</div></div>
            <span class="chev">›</span>
            </a>
        </div>
      </div>
    </div>
  </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const yearData     = @json($researchByYear);
const deptData     = @json($deptDistribution);
// --- Dynamic "nice" step size calculator ---
// Picks a clean step (1, 2, 5, 10, 20, 50, 100...) so the y-axis always
// shows a readable number of gridlines no matter how big the data gets.
function getNiceStep(maxValue, targetTicks = 5) {
    if (!maxValue || maxValue <= 0) return 10;
    const roughStep = maxValue / targetTicks;
    const magnitude = Math.pow(10, Math.floor(Math.log10(roughStep)));
    const residual = roughStep / magnitude;
    let niceFactor;
    if (residual > 5) niceFactor = 10;
    else if (residual > 2) niceFactor = 5;
    else if (residual > 1) niceFactor = 2;
    else niceFactor = 1;
    return niceFactor * magnitude;
}

const yearValues  = Object.values(yearData);
const yearMax     = Math.max(...yearValues, 0);
const yearStep    = getNiceStep(yearMax, 5);
new Chart(document.getElementById('yearChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(yearData),
        datasets: [{
            data: yearValues,
            backgroundColor: '#1AA05B'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: false
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                suggestedMax: Math.ceil(
                    (yearMax + yearStep * 0.2) / yearStep
                ) * yearStep,
                ticks: {
                    stepSize: yearStep,
                    autoSkip: false
                }
            },
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 45,
                    font: {
                        size: 10
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('deptChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(deptData),
        datasets: [{
            data: Object.values(deptData),
            backgroundColor: ['#2E6FE0', '#1AA05B', '#9AA4B2'] // only 3 colors now
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
});
</script>
@extends('partials.footer')
