import { ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexFollowing } from './index';

describe('Index', () => {
  let component: IndexFollowing;
  let fixture: ComponentFixture<IndexFollowing>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [IndexFollowing],
    }).compileComponents();

    fixture = TestBed.createComponent(IndexFollowing);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
