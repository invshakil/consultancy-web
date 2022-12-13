import HttpClient from '../index'

class JobApi extends HttpClient {
    list(page = 1, query) {
        return this.requestType('get').request(`/jobs?page=${page}&${query}`)
    }

    get(slug) {
        return this.requestType('get').request(`/jobs/${slug}/edit`)
    }
    save(payload) {
        let url = this.requestType('post');

        if (payload.image !== null) {
            url = url.isMultimedia();
        }

        return url.formBody(payload).request(`jobs`)
    }

    update(payload) {
        let url = this.requestType('post');

        if (payload.image !== null) {
            url = url.isMultimedia();
        }
        return url.formBody(payload).request(`jobs/${payload.id}`)
    }

    delete(id) {
        return this.requestType('delete').request(`jobs/${id}`)
    }
}

const jobApi = new JobApi()
export default jobApi
