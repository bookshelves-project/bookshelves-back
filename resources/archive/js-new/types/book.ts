import { Model } from './model'

export class Book extends Model {
  constructor(
    public id: number,
    public category_id: number,
    public user_id: number,
    public title: string,
    public status: string,
    public summary: string,
    public body: string,
    public published_at: string,
    public pin: boolean,
    public promote: boolean,
    public slug: string,
    public meta_title: string,
    public meta_description: string,
    public created_at: string,
    public updated_at: string,
    public category: PostCategory,
    // public user: User,
    // public tags: Tag[]
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}

export class PostCategory extends Model {
  constructor(
    public id: number,
    public name: string,
    public slug: string,
    public universe: string
  ) {
    super(id)
  }
  toString() {
    return this.name
  }
}