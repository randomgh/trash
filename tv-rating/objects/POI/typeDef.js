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
    createPOI(poi: CreatePOIInput): POI!
    updatePOI(_id: String!, poi: UpdatePOIInput!): POI!
    deletePOI(_id: String!): POI!
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