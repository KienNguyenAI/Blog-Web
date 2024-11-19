export const bioInfoMethods = {
    // Công việc hiện tại
    data() {
        return {
            jobs: [],
            role: "",
            company: "",
            currentlyWorking: false,
            openJobModalState: false,
            editingJobIndex: null,

            // Học vấn
            education: [],
            degree: "",
            school: "",
            currentlyStudying: false,
            openEducationModalState: false,
            editingEducationIndex: null,

            // Nơi ở hiện tại
            currentPlaces: [],
            place: "",
            openPlaceModalState: false,
            editingPlaceIndex: null,
        };
    },

    methods: {
        // Công việc
        openJobModal() {
            if (this.editingJobIndex === null) {
                this.role = "";
                this.company = "";
                this.currentlyWorking = false;
            }
            this.openJobModalState = true;
        },
        editJob(index) {
            this.editingJobIndex = index;
            const job = this.jobs[index];
            const [role, company] = job.split(' tại ');
            this.role = role.replace('Hiện đang làm ', '');
            this.company = company;
            this.currentlyWorking = job.startsWith('Hiện đang làm');
            this.openJobModalState = true;
        },
        handleJobOk() {
            let jobText = "";
            if (this.currentlyWorking) {
                jobText = `Hiện đang làm ${this.role} tại ${this.company}`;
            } else {
                jobText = `${this.role} tại ${this.company}`;
            }

            if (this.editingJobIndex !== null) {
                this.jobs[this.editingJobIndex] = jobText;
            } else {
                this.jobs.push(jobText);
            }

            this.openJobModalState = false;
            this.editingJobIndex = null;
        },
        handleJobCancel() {
            this.openJobModalState = false;
            this.editingJobIndex = null;
        },
        deleteJob(index) {
            this.jobs.splice(index, 1);
        },

        // Học vấn
        openEducationModal() {
            if (this.editingEducationIndex === null) {
                this.degree = "";
                this.school = "";
                this.currentlyStudying = false;
            }
            this.openEducationModalState = true;
        },
        editEducation(index) {
            this.editingEducationIndex = index;
            const edu = this.education[index];
            const [degree, school] = edu.split(' tại ');
            this.degree = degree.replace('Đang học ', '');
            this.school = school;
            this.currentlyStudying = edu.startsWith('Đang học');
            this.openEducationModalState = true;
        },
        handleEducationOk() {
            let eduText = "";
            if (this.currentlyStudying) {
                eduText = `Đang học ${this.degree} tại ${this.school}`;
            } else {
                eduText = `${this.degree} tại ${this.school}`;
            }

            if (this.editingEducationIndex !== null) {
                this.education[this.editingEducationIndex] = eduText;
            } else {
                this.education.push(eduText);
            }

            this.openEducationModalState = false;
            this.editingEducationIndex = null;
        },
        handleEducationCancel() {
            this.openEducationModalState = false;
            this.editingEducationIndex = null;
        },
        deleteEducation(index) {
            this.education.splice(index, 1);
        },

        // Nơi ở hiện tại
        openPlaceModal() {
            this.openPlaceModalState = true;
            if (this.editingPlaceIndex !== null) {
                this.place = this.currentPlaces[this.editingPlaceIndex];
            }
        },
        handlePlaceOk() {
            if (this.editingPlaceIndex !== null) {
                this.currentPlaces[this.editingPlaceIndex] = this.place;
            } else {
                this.currentPlaces.push(this.place);
            }
            this.openPlaceModalState = false;
            this.editingPlaceIndex = null;
        },
        handlePlaceCancel() {
            this.openPlaceModalState = false;
            this.editingPlaceIndex = null;
        },
        deletePlace(index) {
            this.currentPlaces.splice(index, 1);
        },
    }
};
