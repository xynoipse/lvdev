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
}

export default new UserResource;
