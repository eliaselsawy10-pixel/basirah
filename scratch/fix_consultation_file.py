import re

path = r'c:\xampp\htdocs\Basirah\resources\views\consultations\index.blade.php'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Find the point where it broke.
# It broke after "gap: 12px;" in the media query.
break_point = content.find("gap: 12px;")
if break_point != -1:
    # We want to keep everything up to "gap: 12px;\n            }\n        }\n    </style>\n@endpush"
    # And then add "@section('content')" and the new sections.
    
    header_to_restore = """            }
        }
    </style>
@endpush

@section('content')
    <!-- ========================================
             BREADCRUMBS
        ======================================== -->
    <section class="breadcrumb-section">
        <div class="container">
            <ul class="breadcrumb-custom">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Shop</a></li>
                <li class="active">Doctor Consultation</li>
            </ul>
        </div>
    </section>

    <!-- ========================================
             PAGE HEADER
        ======================================== -->
    <section class="page-header">
        <div class="container">
            <h1>Doctor Consultation</h1>
            <p>Book a virtual consultation with our certified optometrists and ophthalmologists.</p>
        </div>
    </section>

    <!-- ========================================
             TAB SECTION
        ======================================== -->
    <section class="tab-section">
        <div class="container">
            <div class="tab-nav">
                <div class="tab-link">
                    <i class="fas fa-video"></i>
                    Video Consultation
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
             MAIN CONTENT
"""
    # Find the start of the next valid section "        ======================================== -->"
    search_start = break_point + len("gap: 12px;")
    next_valid = content.find("        ======================================== -->", search_start)
    
    if next_valid != -1:
        new_content = content[:search_start] + "\n" + header_to_restore + content[next_valid:]
        with open(path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print("Successfully restored file structure and added brand headers.")
    else:
        print("Could not find recovery anchor.")
else:
    print("Could not find break point.")
