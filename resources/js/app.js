import './bootstrap';

/*
|--------------------------------------------------------------------------
| Theme Management
|--------------------------------------------------------------------------
*/

const themeToggle = document.getElementById('theme-toggle');
const themeIcon = document.getElementById('theme-icon');

const savedTheme = localStorage.getItem('theme');

const prefersDark = window.matchMedia(
    '(prefers-color-scheme: dark)'
).matches;

const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');

function applyTheme(theme) {
    document.documentElement.classList.toggle(
        'dark',
        theme === 'dark'
    );

    if (themeIcon) {
        themeIcon.textContent = theme === 'dark' ? '☀' : '☾';
    }

    localStorage.setItem('theme', theme);
}

applyTheme(initialTheme);

themeToggle?.addEventListener('click', () => {
    const isDark = document.documentElement.classList.contains('dark');

    applyTheme(isDark ? 'light' : 'dark');
});


/*
|--------------------------------------------------------------------------
| Mobile Navigation
|--------------------------------------------------------------------------
*/

const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const menuIcon = document.getElementById('menu-icon');

function closeMobileMenu() {
    mobileMenu?.classList.add('hidden');

    mobileMenuButton?.setAttribute('aria-expanded', 'false');

    if (menuIcon) {
        menuIcon.textContent = '☰';
    }
}

mobileMenuButton?.addEventListener('click', () => {
    const isExpanded =
        mobileMenuButton.getAttribute('aria-expanded') === 'true';

    mobileMenu?.classList.toggle('hidden');

    mobileMenuButton.setAttribute(
        'aria-expanded',
        String(!isExpanded)
    );

    if (menuIcon) {
        menuIcon.textContent = isExpanded ? '☰' : '✕';
    }
});

mobileMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeMobileMenu);
});


/*
|--------------------------------------------------------------------------
| Admin Sidebar Mobile
|--------------------------------------------------------------------------
*/

const adminMenuButton = document.getElementById('admin-menu-button');
const adminSidebar = document.getElementById('admin-sidebar');
const adminOverlay = document.getElementById('admin-overlay');

function closeAdminSidebar() {
    adminSidebar?.classList.add('-translate-x-full');
    adminOverlay?.classList.add('hidden');

    adminMenuButton?.setAttribute('aria-expanded', 'false');
}

adminMenuButton?.addEventListener('click', () => {
    const isOpen =
        adminMenuButton.getAttribute('aria-expanded') === 'true';

    adminSidebar?.classList.toggle('-translate-x-full');
    adminOverlay?.classList.toggle('hidden');

    adminMenuButton.setAttribute(
        'aria-expanded',
        String(!isOpen)
    );
});

adminOverlay?.addEventListener('click', closeAdminSidebar);


/*
|--------------------------------------------------------------------------
| Login Password Toggle
|--------------------------------------------------------------------------
*/

const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('toggle-password');

togglePassword?.addEventListener('click', () => {
    if (!passwordInput) return;

    const isPassword = passwordInput.type === 'password';

    passwordInput.type = isPassword ? 'text' : 'password';

    togglePassword.textContent = isPassword ? 'Hide' : 'Show';

    togglePassword.setAttribute(
        'aria-label',
        isPassword ? 'Hide password' : 'Show password'
    );
});


/*
|--------------------------------------------------------------------------
| Profile Photo Preview
|--------------------------------------------------------------------------
*/

const photoInput = document.getElementById('photo-input');
const photoPreview = document.getElementById('photo-preview');
const photoPlaceholder = document.getElementById('photo-placeholder');

let photoPreviewUrl = null;

photoInput?.addEventListener('change', () => {
    const file = photoInput.files?.[0];

    if (!file) return;

    if (!file.type.startsWith('image/')) {
        photoInput.value = '';

        alert('File yang dipilih harus berupa gambar.');

        return;
    }

    if (photoPreviewUrl) {
        URL.revokeObjectURL(photoPreviewUrl);
    }

    photoPreviewUrl = URL.createObjectURL(file);

    if (photoPreview) {
        photoPreview.src = photoPreviewUrl;
        photoPreview.classList.remove('hidden');
    }

    photoPlaceholder?.classList.add('hidden');
});


/*
|--------------------------------------------------------------------------
| Skill Category Modal Management
|--------------------------------------------------------------------------
*/

const categoryModal = document.getElementById('category-modal');
const categoryForm = document.getElementById('category-form');
const deleteModal = document.getElementById('delete-modal');
const deleteForm = document.getElementById('delete-form');

const categoryModalTitle = document.getElementById('category-modal-title');
const categoryModalDescription = document.getElementById('category-modal-description');
const categorySubmitButton = document.getElementById('category-submit-button');

const categoryName = document.getElementById('category-name');
const categoryDescription = document.getElementById('category-description');
const categorySortOrder = document.getElementById('category-sort-order');
const categoryIsActive = document.getElementById('category-is-active');
const categoryMethod = document.getElementById('category-method');

const deleteCategoryName = document.getElementById('delete-category-name');

let activeModal = null;

function openModal(modal) {
    if (!modal) return;

    activeModal = modal;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}

function closeModal(modal) {
    if (!modal) return;

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    if (activeModal === modal) {
        activeModal = null;
    }

    if (!document.querySelector('[data-modal].flex')) {
        document.body.classList.remove('overflow-hidden');
    }
}

function openCategoryModal(mode, button) {
    if (!categoryModal || !categoryForm) return;

    categoryForm.reset();

    if (mode === 'edit') {
        const updateUrl = button.dataset.categoryUpdateUrl;

        categoryModalTitle.textContent = 'Edit Category';
        categoryModalDescription.textContent =
            'Perbarui informasi kategori Skills.';

        categoryForm.action = updateUrl;
        categoryMethod.value = 'PUT';

        categoryName.value = button.dataset.categoryName || '';
        categoryDescription.value =
            button.dataset.categoryDescription || '';

        categorySortOrder.value =
            button.dataset.categoryOrder || 0;

        categoryIsActive.checked =
            button.dataset.categoryActive === '1';

        categorySubmitButton.textContent = 'Update Category';

    } else {
        categoryModalTitle.textContent = 'New Category';
        categoryModalDescription.textContent =
            'Lengkapi informasi kategori Skills.';

        categoryForm.action = categoryForm.dataset.storeUrl;
        categoryMethod.value = 'POST';

        categorySortOrder.value = 0;
        categoryIsActive.checked = true;

        categorySubmitButton.textContent = 'Save Category';
    }

    openModal(categoryModal);

    categoryName?.focus();
}

function openDeleteModal(button) {
    if (!deleteModal || !deleteForm) return;

    deleteForm.action = button.dataset.deleteUrl;

    deleteCategoryName.textContent =
        button.dataset.deleteName || '';

    openModal(deleteModal);
}

/*
|--------------------------------------------------------------------------
| Project Category Modal Management
|--------------------------------------------------------------------------
*/

const projectCategoryModal = document.getElementById('project-category-modal');
const projectCategoryForm = document.getElementById('project-category-form');
const projectCategoryDeleteModal = document.getElementById('project-category-delete-modal');
const projectCategoryDeleteForm = document.getElementById('project-category-delete-form');

const projectCategoryModalTitle = document.getElementById('project-category-modal-title');
const projectCategoryModalDescription = document.getElementById('project-category-modal-description');
const projectCategorySubmitButton = document.getElementById('project-category-submit-button');

const projectCategoryName = document.getElementById('project-category-name');
const projectCategoryDescription = document.getElementById('project-category-description');
const projectCategorySortOrder = document.getElementById('project-category-sort-order');
const projectCategoryIsActive = document.getElementById('project-category-is-active');
const projectCategoryMethod = document.getElementById('project-category-method');

const projectCategoryDeleteName = document.getElementById('project-category-delete-name');
const projectCategoryDeleteInfo = document.getElementById('project-category-delete-info');

function openProjectCategoryModal(mode, button = null) {
    if (!projectCategoryModal || !projectCategoryForm) return;

    projectCategoryForm.reset();

    if (mode === 'edit') {
        if (!button) return;

        projectCategoryModalTitle.textContent = 'Edit Category';
        projectCategoryModalDescription.textContent =
            'Perbarui informasi kategori proyek.';

        projectCategoryForm.action =
            button.dataset.projectCategoryUpdateUrl;

        projectCategoryMethod.value = 'PUT';

        projectCategoryName.value =
            button.dataset.projectCategoryName || '';

        projectCategoryDescription.value =
            button.dataset.projectCategoryDescription || '';

        projectCategorySortOrder.value =
            button.dataset.projectCategoryOrder || '0';

        projectCategoryIsActive.checked =
            button.dataset.projectCategoryActive === '1';

        projectCategorySubmitButton.textContent = 'Update Category';

    } else {
        projectCategoryModalTitle.textContent = 'New Category';
        projectCategoryModalDescription.textContent =
            'Lengkapi informasi kategori proyek.';

        projectCategoryForm.action =
            projectCategoryForm.dataset.storeUrl;

        projectCategoryMethod.value = 'POST';

        projectCategorySortOrder.value = '0';
        projectCategoryIsActive.checked = true;

        projectCategorySubmitButton.textContent = 'Save Category';
    }

    openModal(projectCategoryModal);
    projectCategoryName?.focus();
}

function openProjectCategoryDeleteModal(button) {
    if (!projectCategoryDeleteModal || !projectCategoryDeleteForm) return;

    projectCategoryDeleteForm.action =
        button.dataset.projectCategoryDeleteUrl;

    projectCategoryDeleteName.textContent =
        button.dataset.projectCategoryDeleteName || '';

    const projectsCount = Number(
        button.dataset.projectCategoryProjectsCount || 0
    );

    projectCategoryDeleteInfo.textContent = projectsCount > 0
        ? `Kategori ini digunakan oleh ${projectsCount} proyek. Proyek tersebut tetap tersimpan, tetapi kategorinya akan dikosongkan.`
        : 'Kategori ini belum digunakan oleh proyek mana pun.';

    openModal(projectCategoryDeleteModal);
}

// Handle modal buttons using event delegation
document.addEventListener('click', (event) => {

    const openCategoryButton = event.target.closest(
        '[data-category-open]'
    );

    if (openCategoryButton) {
        openCategoryModal(
            openCategoryButton.dataset.categoryOpen,
            openCategoryButton
        );

        return;
    }

        const openProjectCategoryButton = event.target.closest(
        '[data-project-category-open]'
    );

    if (openProjectCategoryButton) {
        openProjectCategoryModal(
            openProjectCategoryButton.dataset.projectCategoryOpen,
            openProjectCategoryButton
        );

        return;
    }

    const openProjectCategoryDeleteButton = event.target.closest(
        '[data-project-category-delete-open]'
    );

    if (openProjectCategoryDeleteButton) {
        openProjectCategoryDeleteModal(openProjectCategoryDeleteButton);

        return;
    }

    const openDeleteButton = event.target.closest(
        '[data-delete-open]'
    );

    if (openDeleteButton) {
        openDeleteModal(openDeleteButton);

        return;
    }

    const closeButton = event.target.closest(
        '[data-modal-close]'
    );

    if (closeButton) {
        const modal = closeButton.closest('[data-modal]');

        closeModal(modal);
    }

});

// Close modal with Escape key
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && activeModal) {
        closeModal(activeModal);
    }
});


/*
|--------------------------------------------------------------------------
| Skill Management
|--------------------------------------------------------------------------
*/

const skillModal = document.getElementById('skill-modal');
const skillForm = document.getElementById('skill-form');
const skillDeleteModal = document.getElementById('skill-delete-modal');
const skillDeleteForm = document.getElementById('skill-delete-form');

const skillModalTitle = document.getElementById('skill-modal-title');
const skillModalDescription = document.getElementById('skill-modal-description');
const skillSubmitButton = document.getElementById('skill-submit-button');

const skillCategory = document.getElementById('skill-category');
const skillName = document.getElementById('skill-name');
const skillIcon = document.getElementById('skill-icon');
const skillLevel = document.getElementById('skill-level');
const skillOrder = document.getElementById('skill-order');
const skillFeatured = document.getElementById('skill-featured');
const skillActive = document.getElementById('skill-active');

const skillDeleteName = document.getElementById('skill-delete-name');

const skillCategoryFilter = document.getElementById('skill-category-filter');

function openSkillModal(mode, button) {
    if (!skillModal || !skillForm) return;

    skillForm.reset();

    if (mode === 'edit') {
        skillModalTitle.textContent = 'Edit Skill';
        skillModalDescription.textContent = 'Perbarui informasi Skill.';

        skillForm.action = button.dataset.skillUpdateUrl;

        document.getElementById('skill-method').value = 'PUT';

        skillCategory.value = button.dataset.skillCategoryId || '';
        skillName.value = button.dataset.skillName || '';
        skillIcon.value = button.dataset.skillIcon || '';
        skillLevel.value = button.dataset.skillLevel || '';
        skillOrder.value = button.dataset.skillOrder || 0;

        skillFeatured.checked = button.dataset.skillFeatured === '1';
        skillActive.checked = button.dataset.skillActive === '1';

        skillSubmitButton.textContent = 'Update Skill';

    } else {
        skillModalTitle.textContent = 'New Skill';
        skillModalDescription.textContent = 'Lengkapi informasi Skill.';

        skillForm.action = skillForm.dataset.storeUrl;

        document.getElementById('skill-method').value = 'POST';

        skillOrder.value = 0;
        skillFeatured.checked = false;
        skillActive.checked = true;

        skillSubmitButton.textContent = 'Save Skill';
    }

    openModal(skillModal);

    skillName?.focus();
}

function openSkillDeleteModal(button) {
    if (!skillDeleteModal || !skillDeleteForm) return;

    skillDeleteForm.action = button.dataset.skillDeleteUrl;

    skillDeleteName.textContent =
        button.dataset.skillDeleteName || '';

    openModal(skillDeleteModal);
}

// Event delegation
document.addEventListener('click', (event) => {

    const openButton = event.target.closest('[data-skill-open]');

    if (openButton) {
        openSkillModal(
            openButton.dataset.skillOpen,
            openButton
        );

        return;
    }

    const deleteButton = event.target.closest('[data-skill-delete-open]');

    if (deleteButton) {
        openSkillDeleteModal(deleteButton);

        return;
    }

});

// Category Filter
skillCategoryFilter?.addEventListener('change', () => {

    const selectedCategory = skillCategoryFilter.value;

    document.querySelectorAll('[data-skill-row]').forEach((row) => {

        const categoryId = row.dataset.categoryId;

        const isVisible =
            selectedCategory === 'all' ||
            categoryId === selectedCategory;

        row.classList.toggle('hidden', !isVisible);

    });

});



/*
|--------------------------------------------------------------------------
| Project Management
|--------------------------------------------------------------------------
*/

const projectModal = document.getElementById('project-modal');
const projectForm = document.getElementById('project-form');

const projectModalTitle = document.getElementById('project-modal-title');
const projectModalDescription = document.getElementById('project-modal-description');

const projectMethod = document.getElementById('project-method');

const projectTitle = document.getElementById('project-title');
const projectCategory = document.getElementById('project-category');
const projectSummary = document.getElementById('project-summary');
const projectDescription = document.getElementById('project-description');
const projectSkills = document.getElementById('project-skills');

const projectThumbnail = document.getElementById('project-thumbnail');
const projectThumbnailPreview = document.getElementById('project-thumbnail-preview');
const projectThumbnailPreviewContainer = document.getElementById(
    'project-thumbnail-preview-container'
);

const projectLiveUrl = document.getElementById('project-live-url');
const projectRepositoryUrl = document.getElementById('project-repository-url');
const projectOrder = document.getElementById('project-order');
const projectStatus = document.getElementById('project-status');

const projectFeatured = document.getElementById('project-featured');
const projectActive = document.getElementById('project-active');

const projectSubmitButton = document.getElementById('project-submit-button');

const projectDeleteModal = document.getElementById('project-delete-modal');
const projectDeleteForm = document.getElementById('project-delete-form');
const projectDeleteName = document.getElementById('project-delete-name');


/**
 * Reset thumbnail preview.
 */
function resetProjectThumbnailPreview() {
    if (!projectThumbnailPreview || !projectThumbnailPreviewContainer) {
        return;
    }

    projectThumbnailPreview.src = '';
    projectThumbnailPreviewContainer.classList.add('hidden');
}


/**
 * Open project modal for create or edit.
 */
function openProjectModal(mode, button = null) {
    if (!projectModal || !projectForm) return;

    projectForm.reset();

    // Reset all project skill checkboxes.
    projectSkills?.querySelectorAll('[data-project-skill]').forEach((checkbox) => {
        checkbox.checked = false;
    });
    resetProjectThumbnailPreview();

    if (mode === 'edit') {
        if (!button) return;

        projectModalTitle.textContent = 'Edit Project';
        projectModalDescription.textContent = 'Perbarui informasi proyek.';

        projectForm.action = button.dataset.projectUpdateUrl;
        projectMethod.value = 'PUT';

        projectTitle.value = button.dataset.projectTitle || '';
        projectCategory.value = button.dataset.projectCategory || '';
        projectSummary.value = button.dataset.projectSummary || '';
        projectDescription.value = button.dataset.projectDescription || '';

        projectLiveUrl.value = button.dataset.projectLiveUrl || '';
        projectRepositoryUrl.value = button.dataset.projectRepositoryUrl || '';

        projectOrder.value = button.dataset.projectOrder || '0';

        // Load project development status.
        projectStatus.value = button.dataset.projectStatus || 'in_progress';

        projectFeatured.checked =
            button.dataset.projectFeatured === '1';

        projectActive.checked =
            button.dataset.projectActive === '1';

        // Restore selected skills.
        const selectedSkills = (
            button.dataset.projectSkills || ''
        ).split(',').filter(Boolean);

        projectSkills.querySelectorAll('[data-project-skill]').forEach((checkbox) => {
            checkbox.checked = selectedSkills.includes(checkbox.value);
        });

        // Restore thumbnail preview.
        const thumbnailUrl = button.dataset.projectThumbnail || '';

        if (thumbnailUrl) {
            projectThumbnailPreview.src = thumbnailUrl;
            projectThumbnailPreviewContainer.classList.remove('hidden');
        }

        projectSubmitButton.textContent = 'Update Project';

    } else {
        projectModalTitle.textContent = 'New Project';
        projectModalDescription.textContent = 'Lengkapi informasi proyek.';

        projectForm.action = projectForm.dataset.storeUrl;
        projectMethod.value = 'POST';

        projectCategory.value = '';

        projectOrder.value = '0';

        // Default status for new projects.
        projectStatus.value = 'in_progress';

        projectFeatured.checked = false;
        projectActive.checked = true;

        projectSubmitButton.textContent = 'Save Project';
    }

    openModal(projectModal);
    projectTitle?.focus();
}


/**
 * Open project delete confirmation modal.
 */
function openProjectDeleteModal(button) {
    if (!projectDeleteModal || !projectDeleteForm) return;

    projectDeleteForm.action = button.dataset.projectDeleteUrl;

    projectDeleteName.textContent =
        button.dataset.projectDeleteName || '';

    openModal(projectDeleteModal);
}


/**
 * Open and delete modal event handlers.
 */
document.addEventListener('click', (event) => {

    const openButton = event.target.closest('[data-project-open]');

    if (openButton) {
        openProjectModal(
            openButton.dataset.projectOpen,
            openButton
        );

        return;
    }

    const deleteButton = event.target.closest(
        '[data-project-delete-open]'
    );

    if (deleteButton) {
        openProjectDeleteModal(deleteButton);
    }

});


/**
 * Thumbnail preview and validation.
 */
projectThumbnail?.addEventListener('change', () => {

    const file = projectThumbnail.files[0];

    if (!file) {
        return;
    }

    const allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    if (!allowedTypes.includes(file.type)) {
        projectThumbnail.value = '';
        alert('Format gambar harus JPG, PNG, atau WebP.');
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        projectThumbnail.value = '';
        alert('Ukuran gambar maksimal 2 MB.');
        return;
    }

    const reader = new FileReader();

    reader.onload = (event) => {
        projectThumbnailPreview.src = event.target.result;
        projectThumbnailPreviewContainer.classList.remove('hidden');
    };

    reader.readAsDataURL(file);

});

/*
|--------------------------------------------------------------------------
| Skills Dropdown
|--------------------------------------------------------------------------
*/
const skillsDropdownButton = document.getElementById(
    'skills-dropdown-button'
);

const skillsDropdownMenu = document.getElementById(
    'skills-dropdown-menu'
);

const skillsDropdownIcon = document.getElementById(
    'skills-dropdown-icon'
);

if (
    skillsDropdownButton &&
    skillsDropdownMenu &&
    skillsDropdownIcon
) {
    skillsDropdownButton.addEventListener('click', () => {
        const isExpanded =
            skillsDropdownButton.getAttribute('aria-expanded') === 'true';

        skillsDropdownButton.setAttribute(
            'aria-expanded',
            String(!isExpanded)
        );

        skillsDropdownMenu.classList.toggle('hidden', isExpanded);
        skillsDropdownIcon.classList.toggle('rotate-180', !isExpanded);
    });

/*
|--------------------------------------------------------------------------
| Projects Dropdown
|--------------------------------------------------------------------------
*/

const projectsDropdownButton = document.getElementById(
    'projects-dropdown-button'
);

const projectsDropdownMenu = document.getElementById(
    'projects-dropdown-menu'
);

const projectsDropdownIcon = document.getElementById(
    'projects-dropdown-icon'
);

if (
    projectsDropdownButton &&
    projectsDropdownMenu &&
    projectsDropdownIcon
) {
    projectsDropdownButton.addEventListener('click', () => {
        const isExpanded =
            projectsDropdownButton.getAttribute('aria-expanded') === 'true';

        projectsDropdownButton.setAttribute(
            'aria-expanded',
            String(!isExpanded)
        );

        projectsDropdownMenu.classList.toggle('hidden', isExpanded);
        projectsDropdownIcon.classList.toggle('rotate-180', !isExpanded);
    });
}

}


/*
|--------------------------------------------------------------------------
| Experience Management
|--------------------------------------------------------------------------
*/

const experienceModal = document.getElementById('experience-modal');
const experienceForm = document.getElementById('experience-form');

const experienceModalTitle = document.getElementById('experience-modal-title');
const experienceModalDescription = document.getElementById('experience-modal-description');

const experienceMethod = document.getElementById('experience-method');

const experienceJobTitle = document.getElementById('experience-job-title');
const experienceCompany = document.getElementById('experience-company');
const experienceEmploymentType = document.getElementById('experience-employment-type');
const experienceLocation = document.getElementById('experience-location');

const experienceStartDate = document.getElementById('experience-start-date');
const experienceEndDate = document.getElementById('experience-end-date');
const experienceEndDateContainer = document.getElementById('experience-end-date-container');
const experienceCurrent = document.getElementById('experience-current');

const experienceDescription = document.getElementById('experience-description');
const experienceActive = document.getElementById('experience-active');

const experienceSubmitButton = document.getElementById('experience-submit-button');

const experienceDeleteModal = document.getElementById('experience-delete-modal');
const experienceDeleteForm = document.getElementById('experience-delete-form');
const experienceDeleteName = document.getElementById('experience-delete-name');


/**
 * Toggle end date based on current employment status.
 */
function toggleExperienceEndDate() {
    if (!experienceCurrent || !experienceEndDateContainer || !experienceEndDate) {
        return;
    }

    const isCurrent = experienceCurrent.checked;

    experienceEndDateContainer.classList.toggle('hidden', isCurrent);
    experienceEndDate.disabled = isCurrent;

    if (isCurrent) {
        experienceEndDate.value = '';
    }
}


/**
 * Open experience modal for create or edit.
 */
function openExperienceModal(mode, button = null) {
    if (!experienceModal || !experienceForm) return;

    experienceForm.reset();

    experienceEndDate.disabled = false;

    if (mode === 'edit') {
        if (!button) return;

        experienceModalTitle.textContent = 'Edit Experience';
        experienceModalDescription.textContent = 'Perbarui informasi pengalaman profesional.';

        experienceForm.action = button.dataset.experienceUpdateUrl;
        experienceMethod.value = 'PUT';

        experienceJobTitle.value = button.dataset.experienceJobTitle || '';
        experienceCompany.value = button.dataset.experienceCompany || '';
        experienceEmploymentType.value = button.dataset.experienceEmploymentType || '';
        experienceLocation.value = button.dataset.experienceLocation || '';

        experienceStartDate.value = button.dataset.experienceStartDate || '';
        experienceEndDate.value = button.dataset.experienceEndDate || '';

        experienceCurrent.checked = button.dataset.experienceCurrent === '1';

        experienceDescription.value = button.dataset.experienceDescription || '';
        experienceActive.checked = button.dataset.experienceActive === '1';

        experienceSubmitButton.textContent = 'Update Experience';

    } else {
        experienceModalTitle.textContent = 'New Experience';
        experienceModalDescription.textContent = 'Lengkapi informasi pengalaman profesional.';

        experienceForm.action = experienceForm.dataset.storeUrl;
        experienceMethod.value = 'POST';

        experienceCurrent.checked = false;
        experienceActive.checked = true;

        experienceSubmitButton.textContent = 'Save Experience';
    }

    toggleExperienceEndDate();

    openModal(experienceModal);
    experienceJobTitle.focus();
}


/**
 * Open experience delete confirmation modal.
 */
function openExperienceDeleteModal(button) {
    if (!experienceDeleteModal || !experienceDeleteForm) return;

    experienceDeleteForm.action = button.dataset.experienceDeleteUrl;

    experienceDeleteName.textContent =
        button.dataset.experienceDeleteName || '';

    openModal(experienceDeleteModal);
}


/**
 * Experience modal event handlers.
 */
document.addEventListener('click', (event) => {

    const openButton = event.target.closest('[data-experience-open]');

    if (openButton) {
        openExperienceModal(
            openButton.dataset.experienceOpen,
            openButton
        );

        return;
    }

    const deleteButton = event.target.closest(
        '[data-experience-delete-open]'
    );

    if (deleteButton) {
        openExperienceDeleteModal(deleteButton);
    }

});


/**
 * Current employment change handler.
 */
experienceCurrent?.addEventListener('change', toggleExperienceEndDate);



/*
|--------------------------------------------------------------------------
| Education Management
|--------------------------------------------------------------------------
*/

const educationModal = document.getElementById('education-modal');
const educationForm = document.getElementById('education-form');

const educationModalTitle = document.getElementById('education-modal-title');
const educationModalDescription = document.getElementById('education-modal-description');

const educationMethod = document.getElementById('education-method');

const educationDegree = document.getElementById('education-degree');
const educationInstitution = document.getElementById('education-institution');
const educationField = document.getElementById('education-field');
const educationLocation = document.getElementById('education-location');

const educationStartDate = document.getElementById('education-start-date');
const educationEndDate = document.getElementById('education-end-date');
const educationEndDateContainer = document.getElementById('education-end-date-container');
const educationCurrent = document.getElementById('education-current');

const educationDescription = document.getElementById('education-description');
const educationActive = document.getElementById('education-active');

const educationSubmitButton = document.getElementById('education-submit-button');

const educationDeleteModal = document.getElementById('education-delete-modal');
const educationDeleteForm = document.getElementById('education-delete-form');
const educationDeleteName = document.getElementById('education-delete-name');


/**
 * Toggle end date based on current education status.
 */
function toggleEducationEndDate() {
    if (!educationCurrent || !educationEndDateContainer || !educationEndDate) {
        return;
    }

    const isCurrent = educationCurrent.checked;

    educationEndDateContainer.classList.toggle('hidden', isCurrent);
    educationEndDate.disabled = isCurrent;

    if (isCurrent) {
        educationEndDate.value = '';
    }
}


/**
 * Open education modal for create or edit.
 */
function openEducationModal(mode, button = null) {
    if (!educationModal || !educationForm) return;

    educationForm.reset();

    educationEndDate.disabled = false;

    if (mode === 'edit') {
        if (!button) return;

        educationModalTitle.textContent = 'Edit Education';
        educationModalDescription.textContent = 'Perbarui informasi riwayat pendidikan.';

        educationForm.action = button.dataset.educationUpdateUrl;
        educationMethod.value = 'PUT';

        educationDegree.value = button.dataset.educationDegree || '';
        educationInstitution.value = button.dataset.educationInstitution || '';
        educationField.value = button.dataset.educationField || '';
        educationLocation.value = button.dataset.educationLocation || '';

        educationStartDate.value = button.dataset.educationStartDate || '';
        educationEndDate.value = button.dataset.educationEndDate || '';

        educationCurrent.checked = button.dataset.educationCurrent === '1';

        educationDescription.value = button.dataset.educationDescription || '';
        educationActive.checked = button.dataset.educationActive === '1';

        educationSubmitButton.textContent = 'Update Education';

    } else {
        educationModalTitle.textContent = 'New Education';
        educationModalDescription.textContent = 'Lengkapi informasi riwayat pendidikan.';

        educationForm.action = educationForm.dataset.storeUrl;
        educationMethod.value = 'POST';

        educationCurrent.checked = false;
        educationActive.checked = true;

        educationSubmitButton.textContent = 'Save Education';
    }

    toggleEducationEndDate();

    openModal(educationModal);
    educationDegree.focus();
}


/**
 * Open education delete confirmation modal.
 */
function openEducationDeleteModal(button) {
    if (!educationDeleteModal || !educationDeleteForm) return;

    educationDeleteForm.action = button.dataset.educationDeleteUrl;

    educationDeleteName.textContent =
        button.dataset.educationDeleteName || '';

    openModal(educationDeleteModal);
}


/**
 * Education modal event handlers.
 */
document.addEventListener('click', (event) => {

    const openButton = event.target.closest('[data-education-open]');

    if (openButton) {
        openEducationModal(
            openButton.dataset.educationOpen,
            openButton
        );

        return;
    }

    const deleteButton = event.target.closest(
        '[data-education-delete-open]'
    );

    if (deleteButton) {
        openEducationDeleteModal(deleteButton);
    }

});


/**
 * Current education change handler.
 */
educationCurrent?.addEventListener('change', toggleEducationEndDate);



/*
|--------------------------------------------------------------------------
| Website Settings - Image Preview
|--------------------------------------------------------------------------
*/

function initializeWebsiteImagePreview(inputId, previewId, placeholderId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);

    if (!input || !preview) return;

    let currentObjectUrl = null;

    input.addEventListener('change', () => {
        const file = input.files?.[0];

        if (!file) return;

        // Pastikan file merupakan gambar.
        if (!file.type.startsWith('image/')) {
            input.value = '';
            return;
        }

        // Hapus object URL sebelumnya.
        if (currentObjectUrl) {
            URL.revokeObjectURL(currentObjectUrl);
        }

        // Buat preview gambar baru.
        currentObjectUrl = URL.createObjectURL(file);

        preview.src = currentObjectUrl;
        preview.classList.remove('hidden');

        if (placeholder) {
            placeholder.classList.add('hidden');
        }
    });
}

// Website Logo Preview
initializeWebsiteImagePreview(
    'site-logo',
    'site-logo-preview',
    'site-logo-placeholder'
);

// Website Favicon Preview
initializeWebsiteImagePreview(
    'site-favicon',
    'site-favicon-preview',
    'site-favicon-placeholder'
);


/*
|--------------------------------------------------------------------------
| Admin Profile Dropdown
|--------------------------------------------------------------------------
*/

const adminProfileButton = document.getElementById('admin-profile-button');
const adminProfileMenu = document.getElementById('admin-profile-menu');
const adminProfileIcon = document.getElementById('admin-profile-icon');

if (adminProfileButton && adminProfileMenu) {
    const closeAdminProfileMenu = () => {
        adminProfileMenu.classList.add('hidden');
        adminProfileButton.setAttribute('aria-expanded', 'false');
        adminProfileIcon?.classList.remove('rotate-180');
    };

    adminProfileButton.addEventListener('click', (event) => {
        event.stopPropagation();

        const isExpanded =
            adminProfileButton.getAttribute('aria-expanded') === 'true';

        adminProfileMenu.classList.toggle('hidden', isExpanded);
        adminProfileButton.setAttribute(
            'aria-expanded',
            String(!isExpanded)
        );

        adminProfileIcon?.classList.toggle('rotate-180', !isExpanded);
    });

    document.addEventListener('click', (event) => {
        if (
            !adminProfileMenu.contains(event.target) &&
            !adminProfileButton.contains(event.target)
        ) {
            closeAdminProfileMenu();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAdminProfileMenu();
        }
    });
}


