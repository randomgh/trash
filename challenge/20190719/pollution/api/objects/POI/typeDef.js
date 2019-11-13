export default `
  type POI {
    _id: String!
    latitude: Float!
    longitude: Float!
  }
  
  extend type Query {
    poi(_id: ID!): POI!
    pois: [POI!]!
  }
  
  extend type Mutation {
    createPOI(user: CreatePOIInput): User!
    updatePOI(_id: String!, user: UpdatePOIInput!): User!
    deletePOI(_id: String!): User!
  }
  
  input CreatePOIInput {
    latitude: Float!
    longitude: Float!
  }
  
  input UpdatePOIInput {
    latitude: Float
    longitude: Float
  }
`;