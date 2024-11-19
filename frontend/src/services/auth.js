
export function isLoggedIn() {
    const user = JSON.parse(localStorage.getItem('user'));
    return user !== null;
}

export function getUser() {
    return JSON.parse(localStorage.getItem('user'));
}

export function logout() {
    localStorage.removeItem('user');
}
