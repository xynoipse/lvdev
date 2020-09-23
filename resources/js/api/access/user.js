import request from '@/utils/request';
import Resource from '@/utils/resource';

class UserResource extends Resource {
  constructor() {
    super('users');
  }

  permissions(id) {
    return request({
      url: `/${this.uri}/${id}/permissions`,
      method: 'get',
    });
  }

  updatePermissions(id, permissions) {
    return request({
      url: `/${this.uri}/${id}/permissions`,
      method: 'put',
      data: { permissions },
    });
  }

  updatePassword(id, password) {
    return request({
      url: `/${this.uri}/${id}/password`,
      method: 'put',
      data: password,
    });
  }

  updateProfile(user) {
    return request({
      url: `profile`,
      method: 'put',
      data: user,
    });
  }
}

export default new UserResource;
