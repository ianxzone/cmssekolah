# Git Update & Push Script for CMS Sekolah v3.0.0
# Run this script from PowerShell in the project root

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  CMS Sekolah v3.0.0 - Git Update" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if git is installed
try {
    $gitVersion = git --version
    Write-Host "✓ Git found: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ Git not found! Please install Git first." -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Step 1: Checking repository status..." -ForegroundColor Yellow
git status

Write-Host ""
Write-Host "Step 2: Adding all changes..." -ForegroundColor Yellow
git add .

Write-Host ""
Write-Host "Step 3: Committing changes..." -ForegroundColor Yellow
git commit -m "release: Version 3.0.0 - Major Security & RBAC Update

🎉 MAJOR RELEASE - Enterprise Grade Features

Security Enhancements (Phase 1 & 2):
- RCE, SQL Injection, XSS, CSRF protection
- Rate limiting (120 req/min)
- Security headers (HSTS, CSP, X-Frame-Options)
- Password policy enforcement

RBAC System (Phase 3):
- 4 roles: Super Admin, Admin, Editor, Author
- 41+ granular permissions
- Role & Permission middleware
- Complete audit trail with activity logging

New Features:
- Testimonials module
- Enhanced Media Manager
- Trix Editor with SVG icons
- Form submissions tracking

Testing:
- 19 automated tests for RBAC
- Security vulnerability tests
- Integration tests

Documentation:
- Complete security guides
- RBAC implementation docs
- Deployment procedures
- User guides

Bug Fixes:
- Fixed Trix editor icon display
- Fixed middleware registration
- Fixed permission sync issue
- Various UI/UX improvements

Breaking Changes:
- Minimum PHP 8.2 required
- New database tables (roles, permissions, activity_logs)
- Enhanced security headers may require configuration

Migration Required: YES
Tests Added: YES (19 tests)
Documentation Updated: YES"

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Commit successful!" -ForegroundColor Green
} else {
    Write-Host "✗ Commit failed. Please check for errors." -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Step 4: Pushing to GitHub..." -ForegroundColor Yellow
Write-Host "Repository: https://github.com/ianxzone/cmssekolah" -ForegroundColor Cyan
Write-Host ""

git push origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  ✓ SUCCESS! v3.0.0 Pushed to GitHub" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next Steps:" -ForegroundColor Yellow
    Write-Host "1. Create a new release on GitHub" -ForegroundColor White
    Write-Host "2. Add release notes from CHANGELOG.md" -ForegroundColor White
    Write-Host "3. Tag version as v3.0.0" -ForegroundColor White
    Write-Host ""
    Write-Host "GitHub URL: https://github.com/ianxzone/cmssekolah" -ForegroundColor Cyan
    Write-Host ""
} else {
    Write-Host ""
    Write-Host "✗ Push failed. Please check:" -ForegroundColor Red
    Write-Host "- Your internet connection" -ForegroundColor Yellow
    Write-Host "- Git authentication (SSH/HTTPS)" -ForegroundColor Yellow
    Write-Host "- Repository permissions" -ForegroundColor Yellow
    Write-Host ""
}

Write-Host "Press any key to exit..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
