import request from './request';

/**
 * Simple RESTful resource class
 */
class Resource {
  constructor(uri) {
    this.uri = uri;
  }

  list(query) {
    return request({
      url: `/${this.uri}`,
      method: 'get',
      params: query,
    });
  }

  get(id) {
    return request({
      url: `/${this.uri}/${id}`,
      method: 'get',
    });
  }

  store(resource) {
    return request({
      url: `/${this.uri}`,
      method: 'post',
      data: resource,
    });
  }

  update(id, resource) {
    return request({
      url: `/${this.uri}/${id}`,
      method: 'put',
      data: resource,
    });
  }

  destroy(id) {
    return request({
      url: `/${this.uri}/${id}`,
      method: 'delete',
    });
  }

  massDestroy(ids) {
    return request({
      url: `/${this.uri}`,
      method: 'delete',
      data: { ids },
    });
  }
}

export { Resource as default };
