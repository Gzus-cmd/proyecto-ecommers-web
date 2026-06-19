import Auth from './Auth'
import Admin from './Admin'
import ProfileController from './ProfileController'

const Controllers = {
    Auth: Object.assign(Auth, Auth),
    Admin: Object.assign(Admin, Admin),
    ProfileController: Object.assign(ProfileController, ProfileController),
}

export default Controllers